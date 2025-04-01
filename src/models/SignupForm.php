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


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name and password are required
            [['name', 'email', 'password', 're_password'], 'required'],
            // name must be at least 3 and maximum 100 characters long
            [['name'],'string','min' => 3,'max' => 100, 'tooShort' => 'Імя повинно містити мінімум 3 символи'],
            [['name'],'string','max' => 100, 'tooLong' => 'Імя повинно містити максимум 100 символів'],
            // email must be a valid email address
            [['email'],'email'],
            [['email'],'unique','targetClass' => User::class,'message' => 'Такий email вже зареєстрований'],            
            // password is validated
            [
                'password',
                'match', 
                'pattern' => '/^[a-z0-9]{6,}$/',
                'message' => 'Пароль повинен містити мінімум 6 символів та складатися лише з літер a-z та цифр 0-9'
            ],
            //
            ['re_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Паролі не співпадають'],
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
            return User::signup($this->name, $this->email, $this->password, $this->re_password);
        }
        return false;
    }
}
