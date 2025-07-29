<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%event_time}}".
 *
 * @property int $id
 * @property int $event_id
 * @property string $start_time
 *
 * @property Event $event
 */
class EventTime extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event_time}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'start_time'], 'required'],
            [['event_id'], 'integer'],
            [['start_time'], 'safe'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'start_time' => Yii::t('app', 'Start Time'),
        ];
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

}
