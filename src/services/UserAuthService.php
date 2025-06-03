<?php

namespace app\services;

use app\models\User;
use Yii;

class UserAuthService
{
    public static function login($email, $password, $rememberMe = false)
    {
        $user = User::findByEmail($email);
        if ($user && Yii::$app->security->validatePassword($password, $user->password_hash)) {
            Yii::$app->user->login($user, $rememberMe ? 3600 * 24 * 30 : 0);
            return $user->access_token;
        }
        return null;
    }

    public static function signup($data)
    {
        $user = User::findByEmail($data['email']);

        if (
            !$user
            && $data['password'] === $data['re_password']
        ) {
            $user = User::createUser([
                'name' => $data['name'],
                'email' => $data['email'],
                'date_of_birth' => $data['date_of_birth'],
                'password' => $data['password'],
                'contact_number' => $data['contact_number']
            ]);
            if ($user) {
                Yii::$app->user->login($user);
                return $user->access_token;
            }
        }
        return null;
    }

    public static function logout()
    {
        Yii::$app->user->logout();
    }

    public static function hashPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    // Інші методи авторизації...
}
