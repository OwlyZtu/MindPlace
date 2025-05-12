<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property-read User|null $user
 *
 */
class UserSettingsForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $re_password;
    public $contact_number;
    public $date_of_birth;

    public function validateAge($attribute, $params)
    {
        $minAge = 16;
        $birthDate = new \DateTime($this->$attribute);
        $today = new \DateTime();
        $age = $today->diff($birthDate)->y;
    
        if ($age < $minAge) {
            $this->addError($attribute, Yii::t('app', 'Ви повинні бути старше {minAge} років', ['minAge' => $minAge]));
        }
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return array_merge(
            User::nameRules(),
            [
                ['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                    $currentUser = Yii::$app->user->identity;
                    if ($currentUser) {
                        $query->andWhere(['!=', 'id', $currentUser->id]);
                    }
                }]
            ],
            User::contactNumberRules(),
            User::date_of_birthRules(),
            [
                ['password', 'string', 'min' => 6],
                ['re_password', 'compare', 'compareAttribute' => 'password'],
            ]
        );
    }


    /**
     * Register a user using the provided name, email and password,
     * then logs in.
     * @return string|null generated access token
     */
    public function userUpdateSettings()
    {
        if ($this->validate()) {
            return User::userUpdateSettings($this->name, $this->email, $this->date_of_birth, $this->password, $this->re_password, $this->contact_number);
        }
        return false;
    }
}
