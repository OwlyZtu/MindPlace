<?php

use yii\db\Migration;

class m250612_121324_extend_user_file_fields_length extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'education_file', $this->string(1000)->null());
        $this->alterColumn('{{%user}}', 'additional_certification_file', $this->string(1000)->null());
        $this->alterColumn('{{%user}}', 'education_file_url', $this->string(1000)->null());
        $this->alterColumn('{{%user}}', 'additional_certification_file_url', $this->string(1000)->null());
    }

    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'education_file', $this->string(255)->null());
        $this->alterColumn('{{%user}}', 'additional_certification_file', $this->string(255)->null());
        $this->alterColumn('{{%user}}', 'education_file_url', $this->string(255)->null());
        $this->alterColumn('{{%user}}', 'additional_certification_file_url', $this->string(255)->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250612_121324_extend_user_file_fields_length cannot be reverted.\n";

        return false;
    }
    */
}
