<?php

namespace app\models;

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
     * @param string $name name
     * @param string $email email
     * @param string|null $contact_number contact number
     * @param string $date_of_birth date of birth
     * @param string $password password
     * @return User|null created user or null if failed
     */
    public static function createUser($name, $email, $date_of_birth, $password, $contact_number = null)
    {
        $user = new self();
        $user->name = $name;
        $user->email = $email;
        $user->contact_number = $contact_number;
        $user->date_of_birth = $date_of_birth;
        $user->password_hash = self::hashPassword($password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString(255);

        return $user->save() ? $user : null;
    }

    /**
     * Updates user information
     *
     * @param int $id user ID
     * @param string|null $name name
     * @param string|null $email email
     * @param string|null $contact_number contact number
     * @param string|null $date_of_birth date of birth
     * @param string|null $password password
     * @param string|null $re_password repeat password
     * @param string|null $role user role
     * @return bool whether the update was successful
     */
    public static function updateUser(
        $id,
        $name = null,
        $email = null,
        $contact_number = null,
        $date_of_birth = null,
        $password = null,
        $re_password = null,
        $role = null
    ) {
        $user = self::findOne($id);
        if (!$user || ($email !== null && ($existing = self::findOne(['email' => $email])) && $existing->id !== $id)) {
            return false;
        }

        // Update user information if new values provided
        if ($name !== null) {
            $user->name = $name;
        }
        if ($email !== null) {
            $user->email = $email;
        }
        if ($contact_number !== null) {
            $user->contact_number = $contact_number;
        }
        if ($date_of_birth !== null) {
            $user->date_of_birth = $date_of_birth;
        }

        // Handle password change
        if ($password !== null && $password === $re_password) {
            $user->password_hash = self::hashPassword($password);
        } elseif ($password !== $re_password) {
            return false;
        }

        // Handle role update
        if ($role !== null) {
            $user->role = $role;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->access_token = Yii::$app->security->generateRandomString(255);
        }

        return $user->save();
    }

    /**
     * Deletes a user
     *
     * @param int $id user ID
     * @return bool whether the deletion was successful
     */
    public static function deleteUser($id)
    {
        return ($user = self::findOne($id)) ? (bool) $user->delete() : false;
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

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password
     *
     * @param string $password password to hash
     * @return string hashed password
     */
    public static function hashPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Logs in a user using name and password
     * Optionally, it can remember the user for a specified duration
     *
     * @return string generated access token
     */
    public static function login($email, $password, $rememberMe = false)
    {
        $user = self::findByEmail($email);

        if ($user && $user->validatePassword($password)) {
            Yii::$app->user->login($user, $rememberMe ? 3600 * 24 * 30 : 0);
            return $user->access_token;
        }

        return null;
    }

    /**
     * Register new user & logs in if valid
     *
     * @return string generated access token
     */
    public static function signup($name, $email, $date_of_birth, $password, $re_password, $contact_number = null)
    {
        $user = self::findByEmail($email);

        if (!$user && $password === $re_password) {
            $user = self::createUser($name, $email, $date_of_birth, $password, $contact_number);
            if ($user) {
                Yii::$app->user->login($user);
                return $user->access_token;
            }
        }

        return null;
    }

    /**
     * Logs out the current user
     * 
     * {@inheritdoc}
     * @return void
     */
    public static function logout()
    {
        Yii::$app->user->logout();
    }
    #endregion

    public static function userUpdateSettings($name = null, $email = null, $date_of_birth = null, $password = null, $re_password = null, $contact_number = null)
    {
        if (
            $name === null && $email === null && $date_of_birth === null &&
            $password === null && $re_password === null && $contact_number === null
        ) {
            return false;
        }

        $user = Yii::$app->user->identity;
        if (!$user) {
            return false;
        }

        // Перевіряємо email перед змінами
        if ($email !== null) {
            $existingUser = self::findByEmail($email);
            if ($existingUser && $existingUser->id !== $user->id) {
                return false;
            }
        }

        // Перевіряємо паролі перед змінами
        if ($password !== null && $re_password !== null && $password !== $re_password) {
            return false;
        }

        // Оновлюємо користувача безпосередньо
        if ($name !== null) {
            $user->name = $name;
        }
        if ($email !== null) {
            $user->email = $email;
        }
        if ($date_of_birth !== null) {
            $user->date_of_birth = $date_of_birth;
        }
        if ($password !== null && $re_password !== null) {
            $user->password_hash = self::hashPassword($password);
        }
        if ($contact_number !== null) {
            $user->contact_number = $contact_number;
        }

        // Зберігаємо зміни безпосередньо
        return $user->save() ? $user->access_token : false;
    }


    #region Rules & Labels
    public static function nameRules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 255],
        ];
    }

    public static function emailRules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
        ];
    }

    public static function contactNumberRules()
    {
        return [
            ['contact_number', 'string', 'min' => 10, 'max' => 10],
            ['contact_number', 'match', 'pattern' => '/^[0-9]+$/', 'message' => Yii::t('app', 'Contact number must contain only digits.')],
        ];
    }
    public static function passwordRules()
    {
        return [
            ['password_hash', 'required'],
            ['password_hash', 'string', 'min' => 6],
        ];
    }

    public static function date_of_birthRules()
    {
        return [
            ['date_of_birth', 'date', 'format' => 'php:Y-m-d'],
            ['date_of_birth', 'validateAge'],
        ];
    }

    public static function auth_keyRules()
    {
        return [
            ['auth_key', 'required'],
            ['auth_key', 'string', 'max' => 32],
        ];
    }

    public static function access_tokenRules()
    {
        return [
            ['access_token', 'required'],
            ['access_token', 'string', 'max' => 255],
        ];
    }

    public static function created_atRules()
    {
        return [
            ['created_at', 'required'],
            ['created_at', 'safe'],
        ];
    }

    public static function roleRules()
    {
        return [
            ['role', 'required'],
            ['role', 'in', 'range' => ['admin', 'default', 'moderator', 'specialist', 'guest']],
        ];
    }

    // public static function validateAge($attribute, $params, $validator)
    // {
    //     $minAge = 16;
    //     $model = $validator->owner;
    
    //     try {
    //         $birthDate = new \DateTime($model->$attribute);
    //         $age = (new \DateTime())->diff($birthDate)->y;
    //         if ($age < $minAge) {
    //             $model->addError($attribute, Yii::t('app', 'Ви повинні бути старше {minAge} років', ['minAge' => $minAge]));
    //         }
    //     } catch (\Exception $e) {
    //         $model->addError($attribute, 'Невірний формат дати.');
    //     }
    // }
    



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Повне ім&#039;я',
            'email' => 'Email',
            'contact_number' => 'Контактний номер',
            'date_of_birth' => 'Дата народження',
            'password_hash' => 'Пароль',
            'role' => 'Роль',
            'auth_key' => 'Ключ авторизації',
            'access_token' => 'Токен доступу',
            'created_at' => 'Дата створення',
        ];
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
