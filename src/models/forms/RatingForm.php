<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class RatingForm extends Model
{
    public $rating;
    public $comment;
    public $user_id;
    public $specialist_id;

    public function rules()
    {
        return [
            [['rating'], 'required'],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            ['comment', 'string', 'max' => 1000],
            [['user_id', 'specialist_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'rating' => 'Рейтинг',
            'comment' => 'Коментар',
        ];
    }

    public function save()
    {
        // Логіка збереження рейтингу і коментаря.
        // Наприклад, створити нову модель Review.

        /*
        $review = new Review();
        $review->user_id = $this->user_id;
        $review->specialist_id = $this->specialist_id;
        $review->rating = $this->rating;
        $review->comment = $this->comment;
        return $review->save();
        */

        return true;
    }
}
