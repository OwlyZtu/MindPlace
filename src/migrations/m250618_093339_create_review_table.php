<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m250618_093339_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull()->check('rating >= 1 AND rating <= 5'),
            'comment' => $this->text()->null(),
            'date' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Індекси
        $this->createIndex('{{%idx-review-doctor_id}}', '{{%review}}', 'doctor_id');
        $this->createIndex('{{%idx-review-client_id}}', '{{%review}}', 'client_id');

        // Зовнішні ключі
        $this->addForeignKey(
            '{{%fk-review-doctor_id}}',
            '{{%review}}',
            'doctor_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-review-client_id}}',
            '{{%review}}',
            'client_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-review-doctor_id}}', '{{%review}}');
        $this->dropForeignKey('{{%fk-review-client_id}}', '{{%review}}');

        $this->dropIndex('{{%idx-review-doctor_id}}', '{{%review}}');
        $this->dropIndex('{{%idx-review-client_id}}', '{{%review}}');

        $this->dropTable('{{%review}}');
    }
}
