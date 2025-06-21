<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m250617_134433_add_google_token_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'google_token', $this->text()->null()->after('auth_key'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'google_token');
    }
}
