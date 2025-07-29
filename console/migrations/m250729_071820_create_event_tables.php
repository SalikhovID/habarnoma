<?php

use common\constants\Status;
use yii\db\Migration;

class m250729_071820_create_event_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'color' => $this->string(7)->notNull()->defaultValue('#ffffff'),
            'repeat_type' => $this->string()->notNull(),
            'repeat_interval' => $this->integer(),
            'repeat_days_week' => $this->string(),
            'repeat_days_month' => $this->string(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Status::ACTIVE->value),
        ]);

        $this->addForeignKey('fk-event-user_id', '{{%event}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        $this->createTable('event_time', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'start_time' => $this->time()->notNull(),
        ]);

        $this->addForeignKey('fk-event_time-event_id', '{{%event_time}}', 'event_id', '{{%event}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250729_071820_create_event_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250729_071820_create_event_tables cannot be reverted.\n";

        return false;
    }
    */
}
