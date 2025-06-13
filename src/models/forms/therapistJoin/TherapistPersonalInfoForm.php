<?php

namespace app\models\forms\therapistJoin;

use Yii;
use yii\base\Model;

class TherapistPersonalInfoForm extends Model
{
    public $name;
    public $date_of_birth;
    public $city;
    public $gender;

    public $email;
    public $contact_number;
    public $social_media;

    public function rules()
    {
        return [
            [
                [
                    'name',
                    'email',
                    'contact_number',
                    'city',
                    'date_of_birth',
                    'gender'
                ],
                'required'
            ],
            ['email', 'email'],
            ['contact_number', 'string', 'max' => 13],
        ];
    }

    public function getAttributeLabels() {
        return [
            'name' => 'Ім\'я',
            'email' => 'Ел. пошта',
            'contact_number' => 'Контактний номер',
            'city' => 'Місто проживання',
            'date_of_birth' => 'Дата народження',
            'gender' => 'Стать',
        ];
    }
}
