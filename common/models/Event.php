<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%event}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $color
 * @property string $repeat_type
 * @property int|null $repeat_interval
 * @property string|null $repeat_days_week
 * @property string|null $repeat_days_month
 * @property string $start_date
 * @property string|null $end_date
 * @property int $status
 *
 * @property EventTime[] $eventTimes
 * @property User $user
 */
class Event extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'repeat_interval', 'repeat_days_week', 'repeat_days_month', 'end_date'], 'default', 'value' => null],
            [['color'], 'default', 'value' => '#ffffff'],
            [['status'], 'default', 'value' => 10],
            [['user_id', 'title', 'repeat_type', 'start_date'], 'required'],
            [['user_id', 'repeat_interval', 'status'], 'integer'],
            [['description'], 'string'],
            [['start_date', 'end_date'], 'safe'],
            [['title', 'repeat_type', 'repeat_days_week', 'repeat_days_month'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'color' => Yii::t('app', 'Color'),
            'repeat_type' => Yii::t('app', 'Repeat Type'),
            'repeat_interval' => Yii::t('app', 'Repeat Interval'),
            'repeat_days_week' => Yii::t('app', 'Repeat Days Week'),
            'repeat_days_month' => Yii::t('app', 'Repeat Days Month'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[EventTimes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventTimes()
    {
        return $this->hasMany(EventTime::class, ['event_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
