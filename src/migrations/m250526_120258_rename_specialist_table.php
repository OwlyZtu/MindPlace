<?php

use yii\db\Migration;

class m250526_120258_rename_specialist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%specialist}}', '{{%specialist_application}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%specialist_application}}', '{{%specialist}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250526_120258_rename_specialist_table cannot be reverted.\n";

        return false;
    }
    */
}
