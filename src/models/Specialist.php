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

        /**
     * Оновлює дані користувача з форми TherapistJoinForm
     * та створює запис у таблиці specialist
     *
     * @param int $userId ID користувача
     * @param array $formData дані з форми TherapistJoinForm
     * @return bool результат операції
     */
    public static function updateUserFromTherapistForm($userId, $formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Оновлення даних користувача
            $user = User::findOne($userId);
            if (!$user) {
                Yii::error('User is null', 'therapist-join');
                return false;
            }

            // Оновлення основних полів користувача
            $user->name = $formData['name'] ?? $user->name;
            $user->email = $formData['email'] ?? $user->email;
            $user->contact_number = $formData['contact_number'] ?? $user->contact_number;
            $user->date_of_birth = $formData['date_of_birth'] ?? $user->date_of_birth;
            $user->city = $formData['city'] ?? $user->city;
            $user->gender = $formData['gender'] ?? $user->gender;
            
            // Оновлення JSON полів
            $jsonFields = ['language', 'therapy_types', 'theme', 'approach_type', 'format', 'specialization', 'experience'];
            foreach ($jsonFields as $field) {
                if (isset($formData[$field]) && is_array($formData[$field])) {
                    $user->$field = json_encode($formData[$field]);
                }
            }
            
            // Оновлення інших полів
            $user->lgbt = $formData['lgbt'] ?? $user->lgbt;
            $user->military = $formData['military'] ?? $user->military;
            $user->education_name = $formData['education_name'] ?? $user->education_name;
            $user->education_file = $formData['education_file'] ?? $user->education_file;
            $user->additional_certification = $formData['additional_certification'] ?? $user->additional_certification;
            $user->additional_certification_file = $formData['additional_certification_file'] ?? $user->additional_certification_file;
            $user->social_media = $formData['social_media'] ?? $user->social_media;
            
            if (!$user->save()) {
                throw new \Exception('Помилка при збереженні даних користувача: ' . json_encode($user->getErrors()));
            }
            
            // Створення або оновлення запису в таблиці specialist
            $specialist = Yii::$app->db->createCommand('SELECT id FROM {{%specialist}} WHERE user_id = :userId')
                ->bindValue(':userId', $userId)
                ->queryScalar();
                
            if (!$specialist) {
                // Створення нового запису
                Yii::$app->db->createCommand()->insert('{{%specialist}}', [
                    'user_id' => $userId,
                    'status' => 'pending',
                    'created_at' => new \yii\db\Expression('NOW()'),
                ])->execute();
            } else {
                // Оновлення існуючого запису
                Yii::$app->db->createCommand()->update('{{%specialist}}', [
                    'status' => 'pending',
                    'updated_at' => new \yii\db\Expression('NOW()'),
                ], 'user_id = :userId', [':userId' => $userId])->execute();
            }
            
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Failed to save specialist: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
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
        Yii::error('Education file: ' . print_r($specialist->education_file, true), 'therapist-join');

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
