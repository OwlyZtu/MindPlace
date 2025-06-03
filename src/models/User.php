<?php

namespace app\models;

use app\services\UserAuthService;
use app\services\DebugService;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $contact_number (optional)
 * @property string $date_of_birth
 * @property string $password_hash
 * @property string $role
 * @property string $auth_key
 * @property string $access_token
 * @property string $created_at
 * @property string|null $city
 * @property string|null $gender
 * @property string[]|null $language
 * @property string[]|null $therapy_types JSON-масив
 * @property string[]|null $theme JSON-масив
 * @property string[]|null $approach_type JSON-масив
 * @property string[]|null $format JSON-масив
 * @property bool|null $lgbt
 * @property bool|null $military
 * @property string[]|null $specialization JSON-масив
 * @property string|null $education_name
 * @property string|null $education_file
 * @property string|null $education_file_url
 * @property string|null $additional_certification
 * @property string|null $additional_certification_file
 * @property string|null $additional_certification_file_url
 * @property string[]|null $experience JSON-масив
 * @property string[]|null $social_media JSON-масив
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Table name in the database
     * 
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }


    #region CRUD

    /**
     * Generates a new user
     *
     * @param array $data user data
     * @return User|null created user or null if failed
     */
    public static function createUser($data)
    {
        $user = new self();
        if (!$user->validate()) {
            Yii::error($user->getErrors(), 'user-create');
            return null;
        }

        // Set default user properties
        $user->name = $data['name'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->contact_number = $data['contact_number'] ?? null;
        $user->date_of_birth = $data['date_of_birth'] ?? null;
        $user->role = $data['role'] ?? 'default';

        // Set specialist properties
        $user->city = $data['city'] ?? null;
        $user->gender = $data['gender'] ?? null;
        $user->language =  json_encode($data['language'] ?? []);
        $user->therapy_types = json_encode($data['therapy_types'] ?? []);
        $user->theme = json_encode($data['theme'] ?? []);
        $user->approach_type = json_encode($data['approach_type'] ?? []);
        $user->format = json_encode($data['format'] ?? []);
        $user->lgbt = $data['lgbt'] ?? false;
        $user->military = $data['military'] ?? false;
        $user->specialization = json_encode($data['specialization'] ?? []);
        $user->education_name = $data['education_name'] ?? '';
        $user->education_file = $data['education_file'] ?? null;
        $user->education_file_url = $data['education_file_url'] ?? '';
        $user->additional_certification = $data['additional_certification'] ?? '';
        $user->additional_certification_file = $data['additional_certification_file'] ?? null;
        $user->additional_certification_file_url = $data['additional_certification_file_url'] ?? '';
        $user->experience = json_encode($data['experience'] ?? '');
        $user->social_media = json_encode($data['social_media'] ?? '');

        // Set security properties
        $user->password_hash = UserAuthService::hashPassword($data['password']);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString(255);

        return $user->save() ? $user : null;
    }

    /**
     * Updates user information
     *
     * @param int $id user ID
     * @param array $data user data
     * @return string|false access_token або false у разі помилки
     */
    public static function updateUser($id, $data)
    {
        $user = self::findOne($id);

        if (
            !$user
            || (isset($data['email']) && $data['email'] !== null
                && ($existing = self::findByEmail($data['email']))
                && $existing->id !== $id)
        ) {
            return false;
        }

        $jsonFields = ['language', 'therapy_types', 'theme', 'approach_type', 'format', 'specialization', 'experience', 'social_media'];

        foreach ($data as $key => $value) {
            if (in_array($key, ['password', 're_password'])) {
                continue;
            }

            if ($user->hasAttribute($key) && $value !== null) {
                $user->$key = in_array($key, $jsonFields) && is_array($value)
                    ? json_encode($value)
                    : $value;
            }
        }

        if (
            isset($data['password'], $data['re_password']) &&
            $data['password'] !== '' && $data['re_password'] !== ''
        ) {
            if ($data['password'] !== $data['re_password']) {
                return false;
            }
            $user->password_hash = UserAuthService::hashPassword($data['password']);
        }

        if (!$user->save()) {
            Yii::error($user->getErrors(), 'user-update');
            return false;
        }

        return $user->access_token;
    }


    /**
     * Оновлення налаштувань користувача для поточного користувача
     *
     * @param array $data user data
     * @return string|false access_token або false у разі помилки
     */
    public static function userUpdateSettings($data)
    {
        if (!is_array($data) || empty($data)) {
            Yii::error('Дані для оновлення порожні або не є масивом', 'user-update-settings');
            return false;
        }

        $user = Yii::$app->user->identity;
        if (!$user) {
            Yii::error('Користувач не авторизований', 'user-update-settings');
            return false;
        }

        // Логування даних для відстеження
        Yii::info('Дані для оновлення користувача: ' . print_r($data, true), 'user-update-settings');

        // Виклик методу updateUser для збереження даних
        return self::updateUser($user->id, $data);
    }

    /**
     * Deletes a user
     *
     * @param int $id user ID
     * @return bool whether the deletion was successful
     */
    public static function deleteUser($id)
    {
        $user = self::findOne($id);
        return $user ? (bool) $user->delete() : false;
    }

    /**
     * Finds user by name
     *
     * @param string $name
     * @return static|null
     */
    public static function findByName($name)
    {
        return self::findOne(['name' => $name]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    public static function getSpecialists($params = '')
    {
        return self::find()->where(['role' => 'specialist'])->all();
    }

    public static function getPatients($params = [])
    {
        return self::find()->where(['role' => 'default'])->all();
    }

    public static function getSpecializationList($params = '')
    {
        return [
            'psyhotherapist' => 'Psyhotherapist',
            'psychologist' => 'Psychologist',
        ];
    }

    public static function getStatusList($params = '')
    {
        return [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'blocked' => 'Blocked',
        ];
    }
    #endregion


    #region IdentityInterface

    /**
     * Finds user by ID
     * 
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds user by access token
     * 
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Gets the ID of the user
     * 
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the auth key of the user
     * 
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the auth key
     * 
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    #endregion

    #region Roles & Access Control

    /**
     * Checks if the user has the specified role
     *
     * @param string $role role to check
     * @return bool whether the user has the specified role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Checks if the user is an admin
     * Admin has the highest level of access and can perform all actions
     * including managing users, articles, and managing specialists
     *
     * @return bool whether the user is an admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Checks if the user is a moderator
     * Moderator has a lower level of access than admin and can perform some actions
     * like managing articles, reveiews and reports
     *
     * @return bool whether the user is a moderator
     */
    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    /**
     * Checks if the user is a specialist (doctor)
     * Specialist has a lower level of access than moderator and can perform some actions
     * 1. creating articles
     * 2. edit their own articles
     * 3. edit own profile
     * 4. chat with users 
     *
     * @return bool whether the user is a specialist
     */
    public function isSpecialist()
    {
        return $this->role === 'specialist';
    }

    /**
     * Checks if the user is a regular user
     * Regular user has the lowest level of access and can perform some actions
     * 1. edit own profile
     * 2. chat with specialists
     * 3. leave reviews
     * 4. leave reports
     * 5. view articles
     * 6. view specialists
     *
     * @return bool whether the user is a regular user
     */
    public function isUser()
    {
        return $this->role === 'default';
    }

    /**
     * Checks if the user is a guest
     * Guest has no access to any actions and can only view articles and specialists
     *
     * @return bool whether the user is a guest
     */
    public function isGuest()
    {
        return $this->role === 'guest';
    }

    /**
     * Checks if the user is logged in
     *
     * @return bool whether the user is logged in
     */
    public function isLoggedIn()
    {
        return !Yii::$app->user->isGuest;
    }
    #endregion


}
