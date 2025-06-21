<?php

use yii\db\Migration;

class m250617_085716_update_schedule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%schedule}}', 'client_id', $this->integer()->null());
        $this->addColumn('{{%schedule}}', 'status', $this->string(50)->defaultValue('scheduled')->notNull());
        $this->addColumn('{{%schedule}}', 'meet_url', $this->string(255)->null());
        $this->addColumn('{{%schedule}}', 'recommendations', $this->text()->null());

        $this->addForeignKey(
            'fk-schedule-client_id',
            '{{%schedule}}',
            'client_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-schedule-client_id', '{{%schedule}}');
        $this->dropColumn('{{%schedule}}', 'client_id');
        $this->dropColumn('{{%schedule}}', 'status');
        $this->dropColumn('{{%schedule}}', 'meet_url');
        $this->dropColumn('{{%schedule}}', 'recommendations');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250617_085716_update_schedule_table cannot be reverted.\n";

        return false;
    }
    */
}
