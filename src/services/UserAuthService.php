<?php

namespace app\services;

use Yii;
use Google\Client;
use Google\Service\Oauth2;
use app\models\User;
use app\models\forms\UserProfileForm;
use app\components\GoogleClient;

class UserAuthService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

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
                'contact_number' => $data['contact_number'],
                'auth_type' => 'default',
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


    // GOOGLE AUTH

    /**
     * Отримати URL для переходу на Google авторизацію
     */
    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Отримати або оновити токен за кодом авторизації
     *
     * @param string $code
     * @return bool|string Повертає помилку або false, якщо успішно
     */
    public function authenticateWithCode(string $code)
    {
        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
        } catch (\Exception $e) {
            Yii::error('Google fetchAccessTokenWithAuthCode Exception: ' . $e->getMessage(), 'google-auth');
            return $e->getMessage();
        }
        if (isset($token['error'])) {
            Yii::error('Google fetchAccessTokenWithAuthCode error response: ' . json_encode($token), 'google-auth');
            return $token['error_description'] ?? 'Unknown error';
        }
        
        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
        }

        file_put_contents(Yii::getAlias('@app/runtime/google-token.json'), json_encode($this->client->getAccessToken()));

        return false;
    }

    /**
     * Отримати дату народження з Google API
     * @return string|null
     */
    public function getUserBirthdate(): ?string
    {
        return GoogleClient::getUserBirthdate($this->client);
    }

    /**
     * Отримати інформацію користувача з Google
     * @return \Google\Service\Oauth2\Userinfoplus|null
     */
    public function getGoogleUser()
    {
        $oauth = new Oauth2($this->client);
        return $oauth->userinfo->get();
    }

    /**
     * Логін або створення користувача по Google даних та формі профілю
     *
     * @param UserProfileForm $profileForm
     * @return User
     */
    public function loginOrCreateUser(UserProfileForm $profileForm): User
    {
        $googleUser = $this->getGoogleUser();

        $user = User::findByEmail($googleUser->email);
        if (!$user) {
            $user = User::createUser([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'auth_type' => 'google',
                'password' => Yii::$app->security->generateRandomString(16),
                'date_of_birth' => $profileForm->birth_date,
                'contact_number' => $googleUser->phoneNumber ?? null,
            ]);
        }

        Yii::$app->user->login($user, 3600 * 24 * 30);

        return $user;
    }
}
