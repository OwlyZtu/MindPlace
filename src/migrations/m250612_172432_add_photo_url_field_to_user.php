<?php

use yii\db\Migration;

class m250612_172432_add_photo_url_field_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'photo_url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'photo_url');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250612_172432_add_photo_url_field_to_user cannot be reverted.\n";

        return false;
    }
    */
}
