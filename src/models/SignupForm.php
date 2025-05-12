<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SignupForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
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
        return [
            ['name', 'required', 'message' => Yii::t('app', 'Name cannot be blank.')],
            
            ['email', 'required', 'message' => Yii::t('app', 'Email cannot be blank.')],
            ['email', 'email', 'message' => Yii::t('app', 'Email is not a valid email address.')],
            ['email', 'unique', 'targetClass' => User::class, 'message' => Yii::t('app', 'This email address has already been taken.')],

            [['contact_number'], 'string', 'max' => 10],
            [['date_of_birth'], 'date', 'format' => 'php:Y-m-d'],
            
            ['password', 'required', 'message' => Yii::t('app', 'Password cannot be blank.')],
            ['password', 'string', 'min' => 8, 'message' => Yii::t('app', 'Password should contain at least 8 characters.')],
            
            ['re_password', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Passwords don\'t match')],
        ];
    }


    /**
     * Register a user using the provided name, email and password,
     * then logs in.
     * @return string|null generated access token
     */
    public function signup()
    {
        if ($this->validate()) {
            return User::signup($this->name, $this->email, $this->date_of_birth, $this->password, $this->re_password, $this->contact_number);
        }
        return false;
    }
}
