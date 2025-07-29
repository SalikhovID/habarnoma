<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_accaunt}}`.
 */
class m250729_050423_create_user_accaunt_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_account}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'chat_id' => $this->bigInteger()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_account-user_id',
            'user_account',
            'user_id',
            'user',
            'id'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_accaunt}}');
    }
}
