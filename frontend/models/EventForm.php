<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Event;
use common\models\EventTime;

/**
 * EventForm is the model behind the event creation form.
 */
class EventForm extends Model
{
    public $title;
    public $color = '#000000';
    public $description;
    public $repeat_type = 'daily';
    public $repeat_interval = 1;
    public $repeat_days_week = [];
    public $repeat_days_month = [];
    public $start_date;
    public $end_date;
    public $event_times = [];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'repeat_type', 'start_date'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['color'], 'string', 'max' => 7],
            [['color'], 'match', 'pattern' => '/^#[0-9A-Fa-f]{6}$/'],
            [['repeat_type'], 'in', 'range' => ['daily', 'weekly', 'monthly']],
            [['repeat_interval'], 'integer', 'min' => 1],
            [['repeat_days_week'], 'each', 'rule' => ['in', 'range' => ['1', '2', '3', '4', '5', '6', '7']]],
            [['repeat_days_month'], 'each', 'rule' => ['in', 'range' => array_map('strval', range(1, 31))]],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['end_date'], 'compare', 'compareAttribute' => 'start_date', 'operator' => '>='],
            [['event_times'], 'validateEventTimes'],

            // Required rules with both server- and client-side logic
            [['repeat_interval'], 'required',
                'when' => function($model) {
                    return $model->repeat_type === 'daily';
                },
                'whenClient' => "function (attribute, value) {
                return $('input[name=\"EventForm[repeat_type]\"]:checked').val() === 'daily';
            }"
            ],

            [['repeat_days_week'], 'required',
                'when' => function($model) {
                    return $model->repeat_type === 'weekly';
                },
                'whenClient' => "function (attribute, value) {
                return $('input[name=\"EventForm[repeat_type]\"]:checked').val() === 'weekly';
            }"
            ],

            [['repeat_days_month'], 'required',
                'when' => function($model) {
                    return $model->repeat_type === 'monthly';
                },
                'whenClient' => "function (attribute, value) {
                return $('input[name=\"EventForm[repeat_type]\"]:checked').val() === 'monthly';
            }"
            ],
        ];
    }


    /**
     * Validates event times
     */
    public function validateEventTimes($attribute, $params)
    {
        if (empty($this->event_times)) {
            $this->addError($attribute, 'At least one event time is required.');
            return;
        }

        $timePattern = '/^([01]?[0-9]|2[0-3]):(00|30)$/';
        foreach ($this->event_times as $index => $time) {
            if (!preg_match($timePattern, $time)) {
                $this->addError($attribute, "Event time #{$index} must be in format HH:MM with minutes as 00 or 30.");
            }
        }
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Event Title',
            'color' => 'Color',
            'description' => 'Description',
            'repeat_type' => 'Repeat Type',
            'repeat_interval' => 'Repeat Every (days)',
            'repeat_days_week' => 'Days of Week',
            'repeat_days_month' => 'Days of Month',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'event_times' => 'Event Times',
        ];
    }

    /**
     * Save the event and event times
     * @return bool whether the event was saved successfully
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Create the event
            $event = new Event();
            $event->user_id = Yii::$app->user->id;
            $event->title = $this->title;
            $event->description = $this->description;
            $event->color = $this->color;
            $event->repeat_type = $this->repeat_type;
            $event->start_date = $this->start_date;
            $event->end_date = $this->end_date;

            // Set repeat specific attributes
            switch ($this->repeat_type) {
                case 'daily':
                    $event->repeat_interval = $this->repeat_interval;
                    break;
                case 'weekly':
                    $event->repeat_days_week = implode(',', $this->repeat_days_week);
                    break;
                case 'monthly':
                    $event->repeat_days_month = implode(',', $this->repeat_days_month);
                    break;
            }

            if (!$event->save()) {
                throw new \Exception('Failed to save event: ' . implode(', ', $event->getFirstErrors()));
            }

            // Create event times
            foreach ($this->event_times as $time) {
                $eventTime = new EventTime();
                $eventTime->event_id = $event->id;
                $eventTime->start_time = $time;

                if (!$eventTime->save()) {
                    throw new \Exception('Failed to save event time: ' . implode(', ', $eventTime->getFirstErrors()));
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->addError('title', $e->getMessage());
            return false;
        }
    }

    /**
     * Get available time options (00:00, 00:30, 01:00, ... 23:30)
     * @return array
     */
    public static function getTimeOptions()
    {
        $options = [];
        for ($hour = 0; $hour < 24; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $options[$time] = $time;
            }
        }
        return $options;
    }

    /**
     * Get days of week options
     * @return array
     */
    public static function getDaysOfWeekOptions()
    {
        return [
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday',
            '7' => 'Sunday',
        ];
    }

    /**
     * Get days of month options
     * @return array
     */
    public static function getDaysOfMonthOptions()
    {
        $options = [];
        for ($day = 1; $day <= 31; $day++) {
            $options[(string)$day] = $day < 10 ? '0' . $day :  (string)$day;
        }
        return $options;
    }
}