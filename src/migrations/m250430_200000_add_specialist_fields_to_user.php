<?php

use yii\db\Migration;

/**
 * Handles adding specialist fields to table `{{%user}}`.
 */
class m250430_200000_add_specialist_fields_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'city', $this->string()->null());
        $this->addColumn('user', 'gender', $this->string()->null());
        $this->addColumn('user', 'language', $this->text()->null());
        $this->addColumn('user', 'therapy_types', $this->text()->null());
        $this->addColumn('user', 'theme', $this->text()->null());
        $this->addColumn('user', 'approach_type', $this->text()->null());
        $this->addColumn('user', 'format', $this->text()->null());
        $this->addColumn('user', 'lgbt', $this->boolean()->null());
        $this->addColumn('user', 'military', $this->boolean()->null());
        $this->addColumn('user', 'specialization', $this->text()->null());
        $this->addColumn('user', 'education_name', $this->string()->null());
        $this->addColumn('user', 'education_file', $this->string()->null());
        $this->addColumn('user', 'additional_certification', $this->string()->null());
        $this->addColumn('user', 'additional_certification_file', $this->string()->null());
        $this->addColumn('user', 'experience', $this->text()->null());
        $this->addColumn('user', 'social_media', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'city');
        $this->dropColumn('user', 'gender');
        $this->dropColumn('user', 'language');
        $this->dropColumn('user', 'therapy_types');
        $this->dropColumn('user', 'theme');
        $this->dropColumn('user', 'approach_type');
        $this->dropColumn('user', 'format');
        $this->dropColumn('user', 'lgbt');
        $this->dropColumn('user', 'military');
        $this->dropColumn('user', 'specialization');
        $this->dropColumn('user', 'education_name');
        $this->dropColumn('user', 'education_file');
        $this->dropColumn('user', 'additional_certification');
        $this->dropColumn('user', 'additional_certification_file');
        $this->dropColumn('user', 'experience');
        $this->dropColumn('user', 'social_media');
    }
}