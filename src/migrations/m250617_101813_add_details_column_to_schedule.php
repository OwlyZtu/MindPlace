<?php

use yii\db\Migration;

class m250617_101813_add_details_column_to_schedule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%schedule}}', 'details', $this->json()->after('duration'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%schedule}}', 'details');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250617_101813_add_details_column_to_schedule cannot be reverted.\n";

        return false;
    }
    */
}
