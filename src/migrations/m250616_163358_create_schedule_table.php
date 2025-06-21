<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%schedule}}`.
 */
class m250616_163358_create_schedule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%schedule}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'datetime' => $this->dateTime()->notNull(),
            'duration' => $this->integer()->notNull()->comment('Duration in minutes'),
            'session_id' => $this->integer()->null(),
        ]);

        // Foreign key to user table (doctor_id)
        $this->addForeignKey(
            'fk-schedule-doctor_id',
            '{{%schedule}}',
            'doctor_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Foreign key to session table (optional)
        $this->addForeignKey(
            'fk-schedule-session_id',
            '{{%schedule}}',
            'session_id',
            '{{%session}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-schedule-session_id', '{{%schedule}}');
        $this->dropForeignKey('fk-schedule-doctor_id', '{{%schedule}}');
        $this->dropTable('{{%schedule}}');
    }
}
