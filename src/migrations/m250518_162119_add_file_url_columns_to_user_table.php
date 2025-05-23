<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m250518_162119_add_file_url_columns_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'education_file_url', $this->string());
        $this->addColumn('{{%user}}', 'additional_certification_file_url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'education_file_url');
        $this->dropColumn('{{%user}}', 'additional_certification_file_url');
    }
}
