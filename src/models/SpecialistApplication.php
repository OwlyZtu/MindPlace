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
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_BLOCKED = 'blocked';

    public static function tableName()
    {
        return 'specialist_application';
    }
    public function rules()
    {
        return [
            [['comment', 'status'], 'string'],
            [['user_id'], 'required'],
        ];
    }


    public static function updateUserFromTherapistForm($userId, $formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            User::updateUser($userId, $formData);

            $SpecialistApplication = Yii::$app->db->createCommand('SELECT id FROM {{%specialist_application}} WHERE user_id = :userId')
                ->bindValue(':userId', $userId)
                ->queryScalar();

            if (!$SpecialistApplication) {
                // new record
                Yii::$app->db->createCommand()->insert('{{%specialist_application}}', [
                    'user_id' => $userId,
                    'status' => 'pending',
                    'created_at' => new \yii\db\Expression('NOW()'),
                ])->execute();
            } else {
                // update existing record
                Yii::$app->db->createCommand()->update('{{%specialist_application}}', [
                    'status' => 'pending',
                    'updated_at' => new \yii\db\Expression('NOW()'),
                ], 'user_id = :userId', [':userId' => $userId])->execute();
            }

            $transaction->commit();
            Yii::info('Successfully saved', 'therapist-join');
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Failed to save SpecialistApplication: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    public static function updateStatus($status)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $SpecialistApplications = self::find()->all();
            foreach ($SpecialistApplications as $SpecialistApplication) {
                $userId = $SpecialistApplication->user_id;
                $user = User::findOne($userId);
                if ($user) {
                    $user->role = 'specialist';
                    $user->save();
                    $SpecialistApplication->status = self::STATUS_APPROVED;
                    $SpecialistApplication->save();
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Failed to save SpecialistApplication: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    public static function deleteSpecialistApplication($id)
    {
        $SpecialistApplication = self::findOne($id);
        return $SpecialistApplication ? (bool)$SpecialistApplication->delete() : false;
    }
    public static function getStatusById($userId)
    {
        $SpecialistApplication = self::findOne(['user_id' => $userId]);
        return $SpecialistApplication?->status;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
