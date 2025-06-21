<?php

use yii\db\Migration;

class m250529_150501_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // specialist_application to user
        $this->addForeignKey(
            'fk_specialist_application_user',
            '{{%specialist_application}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // specialist_application to admin
        $this->addForeignKey(
            'fk_specialist_application_admin',
            '{{%specialist_application}}',
            'admin_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_specialist_application_user', '{{%specialist_application}}');
        $this->dropForeignKey('fk_specialist_application_admin', '{{%specialist_application}}');
    }
}
