<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $client_id
 * @property int $rating
 * @property string|null $comment
 * @property string $date
 *
 * @property User $doctor
 * @property User $client
 */
class Review extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'review';
    }

    public function rules(): array
    {
        return [
            [['doctor_id', 'client_id', 'rating'], 'required'],
            [['doctor_id', 'client_id', 'rating'], 'integer'],
            ['rating', 'in', 'range' => [1, 2, 3, 4, 5]],
            ['comment', 'string'],
            ['date', 'safe'],

            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['doctor_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Лікар',
            'client_id' => 'Клієнт',
            'rating' => 'Оцінка',
            'comment' => 'Коментар',
            'date' => 'Дата',
        ];
    }

    public static function createReview($data)
    {
        $review = new Review();
        $review->doctor_id = $data['doctor_id'];
        $review->client_id = $data['client_id'];
        $review->rating = $data['rating'];
        $review->comment = $data['comment'];
        if (!$review->save()) {
            Yii::error($review->getErrors(),'review-create');
            return false;
        } else {
            return $review;
        }
    }

    public static function deleteReview($id)
    {
        $review = self::getReviewById($id);
        if (!$review) {
            return null;
        }
        if (!$review->delete()) {
            Yii::error('Failed to delete review' . json_encode($review->getErrors()), 'session-delete');
            return null;
        } else {
            Yii::$app->session->setFlash('success', 'Review deleted successfully.');
            return $review;
        }
    }

    public static function getReviewsByDoctorId($doctorId, $order = 'SORT_DESC')
    {
        return self::find()
            ->where(['doctor_id' => $doctorId])
            ->orderBy(['rating' => $order])
            ->all();
    }
    public static function getReviewById($id)
    {
        return self::findOne(['id' => $id]);
    }
    
    public static function getAverageRating($doctorId): ?float
    {
        return Review::find()
            ->where(['doctor_id' => $doctorId])
            ->average('rating');
    }
    
    public function getDoctor()
    {
        return $this->hasOne(User::class, ['id' => 'doctor_id']);
    }

    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }
}
