<?php

namespace app\models\admin;

class SpecialistJoinForm extends \yii\db\ActiveRecord
{
    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_REJECTED = 2;

    public static function tableName()
    {
        return 'specialist_join_form';
    }

    public function rules()
    {
        return [
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['status'], 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
        ];
    }

    public function getStatusLabel()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Очікує',
            self::STATUS_APPROVED => 'Схвалено',
            self::STATUS_REJECTED => 'Відхилено',
        };
    }
}
