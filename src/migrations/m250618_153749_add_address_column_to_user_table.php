<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m250618_153749_add_address_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'address', $this->string()->null()->after('city'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'address');
    }
}
