<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m250618_155233_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->string(255)->notNull()->defaultValue('reviewing'),
        ]);

        // Індекс для doctor_id
        $this->createIndex(
            '{{%idx-article-doctor_id}}',
            '{{%article}}',
            'doctor_id'
        );

        // Зовнішній ключ
        $this->addForeignKey(
            '{{%fk-article-doctor_id}}',
            '{{%article}}',
            'doctor_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-article-doctor_id}}', '{{%article}}');
        $this->dropIndex('{{%idx-article-doctor_id}}', '{{%article}}');
        $this->dropTable('{{%article}}');
    }
}
