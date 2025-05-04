<?php

namespace app\models;

use Yii;
use yii\base\Model;

use app\models\Specialist;

/**
 * TherapistJoinForm is the model behind the TherapistJoin form.
 */
class TherapistJoinForm extends Model
{

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // required fields
            [
                [
                    'name',
                    'email',
                    'contact_number',
                    'city',
                    'date_of_birth',
                    'gender',
                    'language',
                    'therapyTypes',
                    'theme',
                    'approach_type',
                    'format',
                    'education_name',
                    'education_file',
                    'experience',
                ],
                'required'
            ],
            
            ['email', 'email'],
            ['therapyTypes', 'each', 'rule' => ['string']],
            ['language', 'each', 'rule' => ['string']],
            ['theme', 'each', 'rule' => ['string']],
            ['approach_type', 'each', 'rule' => ['string']],
            ['format', 'each', 'rule' => ['string']],
            ['specialization', 'each', 'rule' => ['string']],
            ['privacy_policy', 'boolean'],
            ['privacy_policy', 'compare', 'compareValue' => true, 'message' => 'Please accept the Privacy Policy'],
            ['education_file', 'file', 'extensions' => 'pdf, doc, docx'],
            ['additional_certification_file', 'file', 'extensions' => 'pdf, doc, docx'],
        ];
    }

    // Personal Information
    public $name;
    public $date_of_birth = '';

    public $city = '';

    public $gender = [
        'male' => 'Male',
        'female' => 'Female',
    ];

    // Contact Information
    public $email;
    public $contact_number;
    public $social_media = '';

    // Therapy spesific
    public $language = [];
    public $therapyTypes = [];
    public $theme = [];
    public $approach_type = [];
    public $format = [];
    public $lgbt = false;
    public $military = false;

    // Education and Experience
    public $specialization = [];
    public $education_name = '';
    public $education_file = '';
    public $additional_certification = '';
    public $additional_certification_file = '';
    public $experience = '';


    // Privacy Policy
    public $privacy_policy;



    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    // Додаємо поля для email повідомлення
    public $subject = 'New Therapist Application';
    public $body;

    public function contact($email)
    {
        if ($this->validate()) {
            // Формуємо текст повідомлення
            $this->body = "New therapist application from: {$this->name}\n"
                . "Email: {$this->email}\n"
                . "Contact number: {$this->contact_number}\n"
                . "City: {$this->city}\n"
                . "Date of birth: {$this->date_of_birth}\n"
                . "Languages: " . implode(', ', $this->language) . "\n"
                . "Therapy types: " . implode(', ', $this->therapyTypes) . "\n"
                . "Themes: " . implode(', ', $this->theme) . "\n"
                . "Format: " . implode(', ', $this->format) . "\n"
                . "Education: {$this->education_name}\n"
                . "Experience: {$this->experience}";

            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
