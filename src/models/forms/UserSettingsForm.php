<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\services\FieldRulesService;

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

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return array_merge(
            FieldRulesService::nameRules(),
            [
                ['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                    $currentUser = Yii::$app->user->identity;
                    if ($currentUser) {
                        $query->andWhere(['!=', 'id', $currentUser->id]);
                    }
                }]
            ],
            FieldRulesService::contactNumberRules(),
            FieldRulesService::date_of_birthRules(),
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
    public function userUpdateSettingsForm()
    {
        if (!$this->validate()) {
            return false;
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'date_of_birth' => $this->date_of_birth,
        ];

        if (!empty($this->password) && !empty($this->re_password)) {
            $data['password'] = $this->password;
            $data['re_password'] = $this->re_password;
        }

        return User::userUpdateSettings($data);
    }
}
