<?php

use yii\db\Migration;

class m250617_130725_drop_session_id_from_schedule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = 'schedule';
        $column = 'session_id';
        $fkName = 'fk-schedule-session_id';

        $schema = $this->db->schema->getTableSchema($table);

        // Видаляємо foreign key, якщо існує
        if ($schema !== null && isset($schema->foreignKeys[$fkName])) {
            $this->dropForeignKey($fkName, $table);
        } else {
            // Перевірка через колонку
            foreach ($schema->foreignKeys as $name => $fk) {
                if (isset($fk[$column])) {
                    $this->dropForeignKey($name, $table);
                    break;
                }
            }
        }

        // Видаляємо колонку, якщо існує
        if ($schema->getColumn($column) !== null) {
            $this->dropColumn($table, $column);
        }
    }

    public function safeDown()
    {
        $this->addColumn('schedule', 'session_id', $this->integer()->null());

        // Якщо потрібно, можеш знову додати foreign key
        $this->addForeignKey(
            'fk-schedule-session_id',
            'schedule',
            'session_id',
            'session',  // якщо таблиця називається session
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250617_130725_drop_session_id_from_schedule cannot be reverted.\n";

        return false;
    }
    */
}
