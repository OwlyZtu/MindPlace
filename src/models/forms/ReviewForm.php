<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Review;

class ReviewForm extends Model
{
    public $rating;
    public $comment;
    public $user_id;
    public $doctor_id;

    public function rules()
    {
        return [
            [['rating'], 'required'],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            ['comment', 'string', 'max' => 1000],
            ['doctor_id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'rating' => 'Рейтинг',
            'comment' => 'Коментар',
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }
        $this->doctor_id = intval($this->doctor_id);
        $this->rating = intval($this->rating);
        return true;
    }
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        $data = [
            'client_id' => Yii::$app->user->identity->id,
            'doctor_id' => $this->doctor_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ];
        Yii::info($data,'review-create');
        $review = Review::createReview($data);
        if (!$review) {
            Yii::$app->session->setFlash('error', 'Сталася помилка при опублікуванні відгуку.');
            return false;
        }
        Yii::$app->session->setFlash('success', 'Відгук успішно додано.');
        return true;
    }
}
