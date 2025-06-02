<?php

use yii\db\Migration;

class m250529_150906_add_new_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // user
        $this->addColumn('{{%user}}', 'experience_years', $this->integer());
        $this->addColumn('{{%user}}', 'rating', $this->decimal(3, 2));
        $this->addColumn('{{%user}}', 'is_available', $this->boolean()->defaultValue(true));
        $this->addColumn('{{%user}}', 'last_active', $this->timestamp());

        // specialist_application
        $this->addColumn('{{%specialist_application}}', 'review_date', $this->timestamp());
        $this->addColumn('{{%specialist_application}}', 'rejection_reason', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'experience_years');
        $this->dropColumn('{{%user}}', 'rating');
        $this->dropColumn('{{%user}}', 'is_available');
        $this->dropColumn('{{%user}}', 'last_active');

        $this->dropColumn('{{%specialist_application}}', 'review_date');
        $this->dropColumn('{{%specialist_application}}', 'rejection_reason');
    }

}
