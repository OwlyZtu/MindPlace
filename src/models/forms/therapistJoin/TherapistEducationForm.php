<?php

namespace app\models\forms\therapistJoin;

use yii\base\Model;

class TherapistEducationForm extends Model
{
    public $specialization;
    public $experience;
    public $education_name = '';
    public $additional_certification = '';

    public function rules()
    {
        return [
            [
                [
                    'specialization',
                    'experience',
                    'education_name',
                ],
                'required',
            ],
        ];
    }

    public function getAttributeLabels()
    {
        return [
            'specialization' => 'Спеціалізація',
            'experience' => 'Стаж роботи',
            'education_name' => 'Назва освітнього закладу',
            'additional_certification' => 'Додаткова сертифікація',
        ];
    }
}
