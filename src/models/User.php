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
     * @param string $password password
     * @return User|null created user or null if failed
     */
    public static function createUser($name, $email, $password)
    {
        $user = new self();
        $user->name = $name;
        $user->email = $email;
        $user->password_hash = self::hashPassword($password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString(255);

        return $user->save() ? $user : null;
    }

    /**
     * Updates user information
     *
     * @param int $id user ID
     * @param string $name name
     * @param string $email email
     * @param string|null $password password
     * @param string|null $re_password repeat password
     * @param string|null $role user role
     * @return bool whether the update was successful
     */
    public static function updateUser($id, $name, $email, $password = null, $re_password = null, $role = null)
    {
        $user = self::findOne($id);
        if (!$user || ($existing = self::findOne(['email' => $email])) && $existing->id !== $id) {
            return false;
        }

        // Update user information
        $user->name = $name;
        $user->email = $email;


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
     * @param string $rname
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
     * Reister new user & logs in
     *
     * @return string generated access token
     */    
    public static function signup($name, $email, $password, $re_password)
    {
        $user = self::findByEmail($email);

        if (!$user && $password === $re_password) {
            $user = self::createUser($name, $email, $password);
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


    #region Rules & Labels

    public function rules()
    {
        return [
            [['name', 'email', 'password_hash', 'role'], 'string', 'max' => 255],
            [['auth_key', 'access_token'], 'string', 'max' => 255],
            [['created_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_hash'], 'string', 'min' => 6],
            [['role'], 'in', 'range' => ['admin', 'user', 'moderator', 'specialist', 'guest']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Full name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'role' => 'Role',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
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
    public function isAdmin()       { return $this->role === 'admin'; }

    /**
     * Checks if the user is a moderator
     * Moderator has a lower level of access than admin and can perform some actions
     * like managing articles, reveiews and reports
     *
     * @return bool whether the user is a moderator
     */
    public function isModerator()   { return $this->role === 'moderator';}

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
    public function isSpecialist()  { return $this->role === 'specialist'; }

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
    public function isUser()        { return $this->role === 'default'; }

    /**
     * Checks if the user is a guest
     * Guest has no access to any actions and can only view articles and specialists
     *
     * @return bool whether the user is a guest
     */
    public function isGuest()       { return $this->role === 'guest'; }

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
