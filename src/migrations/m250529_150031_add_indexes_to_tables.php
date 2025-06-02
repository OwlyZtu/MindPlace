<?php

use yii\db\Migration;

class m250529_150031_add_indexes_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // user table index
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
        $this->createIndex('idx_user_role', '{{%user}}', 'role');
        $this->createIndex('idx_user_city', '{{%user}}', 'city');
        $this->createIndex('idx_user_gender', '{{%user}}', 'gender');

        // specialist search index
        $this->createIndex(
            'idx_user_role_city_gender',
            '{{%user}}',
            ['role', 'city', 'gender']
        );

        // specialist_application table index
        $this->createIndex('idx_specialist_application_status', '{{%specialist_application}}', 'status');
        $this->createIndex('idx_specialist_application_created_at', '{{%specialist_application}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // delete index from user
        $this->dropIndex('idx_user_email', '{{%user}}');
        $this->dropIndex('idx_user_role', '{{%user}}');
        $this->dropIndex('idx_user_city', '{{%user}}');
        $this->dropIndex('idx_user_gender', '{{%user}}');
        $this->dropIndex('idx_user_role_city_gender', '{{%user}}');

        // delete index from specialist_application
        $this->dropIndex('idx_specialist_application_status', '{{%specialist_application}}');
        $this->dropIndex('idx_specialist_application_created_at', '{{%specialist_application}}');
    }
}
