<?php

namespace app\models;

use app\services\UserAuthService;
use app\models\forms\FormOptions;

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
 * @property string|null $google_token
 * @property string $access_token
 * @property string $created_at
 * @property string $auth_type
 * @property string|null $city
 * @property string|null $address
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
 * @property string|null $photo
 * @property string|null $photo_url
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
        Yii::info('User update data: ' . json_encode($data), 'user-update');

        if (!$user) {
            Yii::error("User ID $id not found", 'user-update');
            return false;
        }

        if (isset($data['email'])) {
            $existing = self::findByEmail($data['email']);
            if ($existing && $existing->id !== $id) {
                Yii::error("Email {$data['email']} is already taken by another user", 'user-update');
                return false;
            }
        }

        $jsonFields = [
            'language',
            'therapy_types',
            'theme',
            'approach_type',
            'format',
            'specialization',
            'experience',
            'social_media'
        ];

        foreach ($data as $field => $value) {
            if (in_array($field, $jsonFields, true)) {
                $user->$field = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
            } else {
                Yii::info("$field = $value", 'user-update');
                $user->$field = $value;
            }
        }

        foreach (['education', 'additional_certification'] as $prefix) {
            if (!empty($data["{$prefix}_file"])) {
                $user->{"{$prefix}_file"} = $data["{$prefix}_file"];
                $user->{"{$prefix}_file_url"} = $data["{$prefix}_file_url"] ?? null;
            }
        }
        if (!empty($data["photo"])) {
            $user->photo = $data["photo"];
            $user->photo_url = $data["photo_url"] ?? null;
        }


        if (!empty($data['password']) && !empty($data['re_password'])) {
            if ($data['password'] !== $data['re_password']) {
                Yii::warning('Passwords do not match', 'user-update');
                return false;
            }
            $user->password_hash = UserAuthService::hashPassword($data['password']);
        }

        if (!$user->save()) {
            Yii::error('User save failed: ' . json_encode($user->getErrors()), 'user-update');
            throw new \RuntimeException('Помилка збереження користувача.');
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
    public static function userUpdateSettings(array $data)
    {
        if (empty($data)) {
            Yii::error('Дані для оновлення порожні або не є масивом', 'user-update-settings');
            Yii::$app->session->setFlash('error', 'Помилка при оновленні профілю');
            return false;
        }

        $user = Yii::$app->user->identity;
        if (!$user) {
            Yii::error('Користувач не авторизований', 'user-update-settings');
            Yii::$app->session->setFlash('error', 'Помилка при оновленні профілю');
            return false;
        }

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
     * Finds user by id
     *
     * @param int $id
     * @return static|null
     */
    public static function findById($id)
    {
        return self::findOne(['id' => $id]);
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
        $user = self::findOne($id);
        if ($user === null) {
            Yii::error("findIdentity: User not found for ID = $id", __METHOD__);
        }
        return $user;
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


    public function getAge(): int
    {
        if (!$this->date_of_birth) {
            return 0;
        }
        $dob = new \DateTime($this->date_of_birth);
        $today = new \DateTime();
        return $today->diff($dob)->y;
    }


    public function getTherapyTypesAsArray(): array
    {
        return $this->getDecodedAttribute('therapy_types');
    }

    public function getThemeAsArray(): array
    {
        return $this->getDecodedAttribute('theme');
    }

    public function getApproachTypeAsArray(): array
    {
        return $this->getDecodedAttribute('approach_type');
    }

    public function getFormatAsArray(): array
    {
        return $this->getDecodedAttribute('format');
    }

    public function getSpecializationAsArray(): array
    {
        return $this->getDecodedAttribute('specialization');
    }

    public function getExperienceAsArray(): array
    {
        return $this->getDecodedAttribute('experience');
    }

    public function getSocialMediaAsArray(): array
    {
        return $this->getDecodedAttribute('social_media');
    }

    public function getLanguageAsArray(): array
    {
        return $this->getDecodedAttribute('language');
    }

    public function getOptionLabel(string $fieldName, string $optionCategory): ?string
    {
        $value = $this->$fieldName;
        return FormOptions::getLabel($optionCategory, $value);
    }

    protected function normalizeJsonArray($value): array
    {
        if (is_array($value)) return $value;
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    public function getOptionLabels(string $fieldName, string $optionCategory): array
    {
        $keys = $this->getDecodedAttribute($fieldName);
        return array_filter(array_map(fn($k) => FormOptions::getLabel($optionCategory, $k), $keys));
    }

    public function getDecodedAttribute(string $attr): array
    {
        return $this->normalizeJsonArray($this->$attr ?? []);
    }
}
