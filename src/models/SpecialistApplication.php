<?php

namespace app\models;

use app\services\UserAuthService;
use Yii;

/**
 * SpecialistApplication model
 *
 * @property int $id
 * @property string $user_id
 * @property string $admin_id (optional)
 * @property string $status
 * @property string $comment (optional)
 * @property string $created_at
 * @property string $updated_at
 */
class SpecialistApplication extends User
{
    public static function tableName()
    {
        return 'specialist_application';
    }

    /**
     * Оновлює дані користувача з форми TherapistJoinForm
     * та створює запис у таблиці Specialist_application
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
            
            // Створення або оновлення запису в таблиці SpecialistApplication
            $SpecialistApplication = Yii::$app->db->createCommand('SELECT id FROM {{%SpecialistApplication}} WHERE user_id = :userId')
                ->bindValue(':userId', $userId)
                ->queryScalar();
                
            if (!$SpecialistApplication) {
                // Створення нового запису
                Yii::$app->db->createCommand()->insert('{{%SpecialistApplication}}', [
                    'user_id' => $userId,
                    'status' => 'pending',
                    'created_at' => new \yii\db\Expression('NOW()'),
                ])->execute();
            } else {
                // Оновлення існуючого запису
                Yii::$app->db->createCommand()->update('{{%SpecialistApplication}}', [
                    'status' => 'pending',
                    'updated_at' => new \yii\db\Expression('NOW()'),
                ], 'user_id = :userId', [':userId' => $userId])->execute();
            }
            
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Failed to save SpecialistApplication: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    #region CRUD
    public static function createSpecialistApplication($data)
    {
        $SpecialistApplication = new self();
        $SpecialistApplication->name = $data['name'] ?? null;
        $SpecialistApplication->email = $data['email'] ?? null;
        $SpecialistApplication->contact_number = $data['contact_number'] ?? null;
        $SpecialistApplication->date_of_birth = $data['date_of_birth'] ?? null;
        $SpecialistApplication->city = $data['city'] ?? null;
        $SpecialistApplication->gender = $data['gender'] ?? [];
        $SpecialistApplication->language = $data['language'] ?? [];
        $SpecialistApplication->therapy_types = $data['therapy_types'] ?? [];
        $SpecialistApplication->theme = $data['theme'] ?? [];
        $SpecialistApplication->approach_type = $data['approach_type'] ?? [];
        $SpecialistApplication->format = $data['format'] ?? [];
        $SpecialistApplication->lgbt = $data['lgbt'] ?? false;
        $SpecialistApplication->military = $data['military'] ?? false;
        $SpecialistApplication->specialization = $data['specialization'] ?? [];
        $SpecialistApplication->education_name = $data['education_name'] ?? '';
        $SpecialistApplication->education_file = $data['education_file'] ?? '';
        Yii::error('Education file: ' . print_r($SpecialistApplication->education_file, true), 'therapist-join');

        $SpecialistApplication->additional_certification = $data['additional_certification'] ?? '';
        $SpecialistApplication->additional_certification_file = $data['additional_certification_file'] ?? '';
        $SpecialistApplication->experience = $data['experience'] ?? '';
        $SpecialistApplication->social_media = $data['social_media'] ?? '';
        $SpecialistApplication->role = 'SpecialistApplication';
        $SpecialistApplication->auth_key = Yii::$app->security->generateRandomString();
        $SpecialistApplication->access_token = Yii::$app->security->generateRandomString(255);

        // Якщо є пароль
        if (isset($data['password'])) {
            $SpecialistApplication->password_hash = UserAuthService::hashPassword($data['password']);
        }

        return $SpecialistApplication->save() ? $SpecialistApplication : null;
    }

    //public static function getSpecialistApplications($params = [])
    // {
    //     return self::find()->where($params)->all();
    // }

    public static function updateSpecialistApplication($id, $data)
    {
        $SpecialistApplication = self::findOne($id);
        if (!$SpecialistApplication) {
            return false;
        }

        foreach ($data as $key => $value) {
            if (property_exists($SpecialistApplication, $key) && $value !== null) {
                $SpecialistApplication->$key = $value;
            }
        }

        // Оновлення пароля, якщо передано
        if (isset($data['password']) && isset($data['re_password']) && $data['password'] === $data['re_password']) {
            $SpecialistApplication->password_hash = UserAuthService::hashPassword($data['password']);
        } elseif (isset($data['password']) && isset($data['re_password']) && $data['password'] !== $data['re_password']) {
            return false;
        }

        return $SpecialistApplication->save();
    }

    public static function deleteSpecialistApplication($id)
    {
        $SpecialistApplication = self::findOne($id);
        return $SpecialistApplication ? (bool)$SpecialistApplication->delete() : false;
    }

    public static function getByStatus($status)
    {
        return self::find()->where(['status' => $status])->all();
    }

    public static function getStatusById($userId)
    {
        $SpecialistApplication = self::findOne(['user_id' => $userId]);
        return $SpecialistApplication?->status;
    }
    #endregion
}
