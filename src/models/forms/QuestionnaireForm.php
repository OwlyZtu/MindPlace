<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * QuestionnaireForm is the model behind the questionnaire form.
 */
class QuestionnaireForm extends Model
{

    public $format;
    public $city;
    public $therapy_types;
    public $theme;
    public $first_time;
    public $approach;
    public $approach_type;
    public $language;
    public $gender;
    public $age;
    public $lgbt;
    public $military;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                [
                    'format',
                    'therapy_types',
                    'theme',
                    'first_time',
                    'approach',
                    'language',
                    'gender',
                    'age'
                ],
                'required'
            ],
        ];
    }



    public function saveQuestionnaireToSession()
    {
        if ($this->validate()) {
            $data = [
                'format' => $this->format,
                'city' => $this->city,
                'therapy_types' => $this->therapy_types,
                'theme' => $this->theme,
                'approach_type' => $this->approach_type,
                'language' => $this->language,
                'gender' => $this->gender,
                'age' => $this->age,
                'lgbt' => $this->lgbt,
                'military' => $this->military,
            ];
            

            // Save data in session
            $session = Yii::$app->session;
            $session->open();
            $session->set('questionnaireData', $data);

            return $data;
        }

        return false;
    }
}
