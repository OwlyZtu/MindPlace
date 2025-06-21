<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%specialist}}`.
 */
class m250518_142546_create_specialist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%specialist}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('ID користувача, який подав заявку'),
            'admin_id' => $this->integer()->null()->comment('ID адміна/модератора, який обробив заявку'),
            'status' => $this->string(20)->notNull()->defaultValue('pending')->comment('Статус заявки: pending, approved, rejected'),
            'comment' => $this->text()->null()->comment('Коментар адміністратора'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk-specialist-user_id',
            '{{%specialist}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-specialist-admin_id',
            '{{%specialist}}',
            'admin_id',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        $this->createIndex('idx-specialist-user_id', '{{%specialist}}', 'user_id');
        $this->createIndex('idx-specialist-admin_id', '{{%specialist}}', 'admin_id');
        $this->createIndex('idx-specialist-status', '{{%specialist}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-specialist-user_id', '{{%specialist}}');
        $this->dropForeignKey('fk-specialist-admin_id', '{{%specialist}}');

        $this->dropIndex('idx-specialist-user_id', '{{%specialist}}');
        $this->dropIndex('idx-specialist-admin_id', '{{%specialist}}');
        $this->dropIndex('idx-specialist-status', '{{%specialist}}');

        $this->dropTable('{{%specialist}}');
    }
}
