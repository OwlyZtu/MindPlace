<?php

namespace app\models;

use app\services\UserAuthService;
use Yii;

/**
 * Specialist model
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
 * @property string $city
 * @property array $gender
 * @property array $language
 * @property array $therapy_types
 * @property array $theme
 * @property array $approach_type
 * @property array $format
 * @property bool $lgbt
 * @property bool $military
 * @property array $specialization
 * @property string $education_name
 * @property string $education_file
 * @property string $additional_certification
 * @property string $additional_certification_file
 * @property string $experience
 * @property string $social_media
 */
class Specialist extends User
{
    public static function tableName()
    {
        return 'specialist';
    }


    #region CRUD
    public static function createSpecialist($data)
    {
        $specialist = new self();
        $specialist->name = $data['name'] ?? null;
        $specialist->email = $data['email'] ?? null;
        $specialist->contact_number = $data['contact_number'] ?? null;
        $specialist->date_of_birth = $data['date_of_birth'] ?? null;
        $specialist->city = $data['city'] ?? null;
        $specialist->gender = $data['gender'] ?? [];
        $specialist->language = $data['language'] ?? [];
        $specialist->therapy_types = $data['therapy_types'] ?? [];
        $specialist->theme = $data['theme'] ?? [];
        $specialist->approach_type = $data['approach_type'] ?? [];
        $specialist->format = $data['format'] ?? [];
        $specialist->lgbt = $data['lgbt'] ?? false;
        $specialist->military = $data['military'] ?? false;
        $specialist->specialization = $data['specialization'] ?? [];
        $specialist->education_name = $data['education_name'] ?? '';
        $specialist->education_file = $data['education_file'] ?? '';
        $specialist->additional_certification = $data['additional_certification'] ?? '';
        $specialist->additional_certification_file = $data['additional_certification_file'] ?? '';
        $specialist->experience = $data['experience'] ?? '';
        $specialist->social_media = $data['social_media'] ?? '';
        $specialist->role = 'specialist';
        $specialist->auth_key = Yii::$app->security->generateRandomString();
        $specialist->access_token = Yii::$app->security->generateRandomString(255);

        // Якщо є пароль
        if (isset($data['password'])) {
            $specialist->password_hash = UserAuthService::hashPassword($data['password']);
        }

        return $specialist->save() ? $specialist : null;
    }

    public static function updateSpecialist($id, $data)
    {
        $specialist = self::findOne($id);
        if (!$specialist) {
            return false;
        }

        foreach ($data as $key => $value) {
            if (property_exists($specialist, $key) && $value !== null) {
                $specialist->$key = $value;
            }
        }

        // Оновлення пароля, якщо передано
        if (isset($data['password']) && isset($data['re_password']) && $data['password'] === $data['re_password']) {
            $specialist->password_hash = UserAuthService::hashPassword($data['password']);
        } elseif (isset($data['password']) && isset($data['re_password']) && $data['password'] !== $data['re_password']) {
            return false;
        }

        return $specialist->save();
    }

    public static function deleteSpecialist($id)
    {
        $specialist = self::findOne($id);
        return $specialist ? (bool)$specialist->delete() : false;
    }
    #endregion
}
