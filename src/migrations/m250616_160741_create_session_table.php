<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%session}}`.
 */
class m250616_160741_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'status' => $this->string(50)->notNull()->defaultValue('sheduled'),
            'datetime' => $this->dateTime()->notNull(),
            'meetUrl' => $this->string(255),
            'reccomendations' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-session-doctor_id',
            '{{%session}}',
            'doctor_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-session-client_id',
            '{{%session}}',
            'client_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-session-doctor_id', '{{%session}}');
        $this->dropForeignKey('fk-session-client_id', '{{%session}}');
        $this->dropTable('{{%session}}');
    }
}
