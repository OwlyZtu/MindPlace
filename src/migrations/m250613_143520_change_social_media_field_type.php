<?php

use yii\db\Migration;

class m250613_143520_change_social_media_field_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'social_media', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'social_media', $this->string(255));
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250613_143520_change_social_media_field_type cannot be reverted.\n";

        return false;
    }
    */
}
