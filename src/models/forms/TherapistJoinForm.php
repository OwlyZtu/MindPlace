<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Specialist;

use yii\web\UploadedFile;


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
                    'therapy_types',
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
            ['contact_number', 'string', 'max' => 13],
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

    public $gender;

    // Contact Information
    public $email;
    public $contact_number;
    public $social_media = '';

    // Therapy spesific
    public $language = [];
    public $therapy_types = [];
    public $theme = [];
    public $approach_type = [];
    public $format = [];
    public $lgbt = false;
    public $military = false;

    // Education and Experience
    public $specialization = [];
    public $education_name = '';
    public $education_file;
    public $additional_certification = '';
    public $additional_certification_file;
    public $experience = '';


    // Privacy Policy
    public $privacy_policy;

    // public $subject = 'New Therapist Application';
    // public $body;


    // public function body_message_join_form()
    // {
    //     return "New therapist application from: {$this->name}\n"
    //         . "Email: {$this->email}\n"
    //         . "Contact number: {$this->contact_number}\n"
    //         . "City: {$this->city}\n"
    //         . "Date of birth: {$this->date_of_birth}\n"
    //         . "Gender: {$this->gender}\n"
    //         . "Languages: " . implode(', ', $this->language) . "\n"
    //         . "Therapy types: " . implode(', ', $this->therapy_types) . "\n"
    //         . "Themes: " . implode(', ', $this->theme) . "\n"
    //         . "Approach type: " . implode(', ', $this->approach_type) . "\n"
    //         . "Format: " . implode(', ', $this->format) . "\n"
    //         . "Education: {$this->education_name} "
    //         . "[Education file {$this->education_file}]\n"
    //         . "Experience: {$this->experience}";
    // }

    // public function contact($email)
    // {
    //     if ($this->validate()) {
    //         $this->body = $this->body_message_join_form();

    //         Yii::$app->mailer->compose()
    //             ->setTo($email)
    //             ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
    //             ->setReplyTo([$this->email => $this->name])
    //             ->setSubject($this->subject)
    //             ->setTextBody($this->body)
    //             ->send();

    //         return true;
    //     }
    //     return false;
    // }


    public function updateUserAsTherapist()
    {
        if ($this->validate()) {
            $uploadedFiles = $this->uploadToS3();

            if ($uploadedFiles === false) {
                Yii::error('Failed to upload files to S3', 'therapist-join');
                return false;
            }

            $user = Yii::$app->user->identity;
            if (!$user->id) {
                Yii::error('User ID is null', 'therapist-join');
                return false;
            }

            Specialist::updateUserFromTherapistForm($user->id, $this->getAttributes());
            return true;
        }

        Yii::error('Validation error!' . $this->getErrors(), 'therapist-join');

        return false;
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->education_file = UploadedFile::getInstance($this, 'education_file');
            $this->additional_certification_file = UploadedFile::getInstance($this, 'additional_certification_file');

            if ($this->education_file === null) {
                Yii::error('Файл education_file не завантажено', 'therapist-join');
                return false;
            }
            return true;
        }
        return false;
    }


    public function uploadToS3()
    {
        if (!$this->validate()) {
            Yii::error('education_file is null in beforeValidate', 'therapist-join');
            return false;
        }

        $s3 = Yii::$app->get('s3Storage');

        // Перевірка ініціалізації S3
        if (!$s3 || !$s3->client) {
            Yii::error('S3 client not initialized properly', 'therapist-join');
            return false;
        }

        $userId = Yii::$app->user->identity->id;
        $directory = "users/{$userId}/documents";

        $educationFileInfo = null;
        $certificationFileInfo = null;

        try {
            if ($this->education_file instanceof UploadedFile) {
                $educationFileInfo = $s3->upload($this->education_file, $directory);
                if (!$educationFileInfo) {
                    Yii::error('Failed to upload education file to S3', 'therapist-join');
                    return false;
                }
            }

            if ($this->additional_certification_file instanceof UploadedFile) {
                $certificationFileInfo = $s3->upload($this->additional_certification_file, $directory);
                if (!$certificationFileInfo) {
                    Yii::error('Failed to upload certification file to S3', 'therapist-join');
                    return false;
                }
            }

            return [
                'education_file' => $educationFileInfo ? $educationFileInfo['path'] : null,
                'education_file_url' => $educationFileInfo ? $educationFileInfo['url'] : null,
                'additional_certification_file' => $certificationFileInfo ? $certificationFileInfo['path'] : null,
                'additional_certification_file_url' => $certificationFileInfo ? $certificationFileInfo['url'] : null,
            ];
        } catch (\Exception $e) {
            Yii::error('Exception during S3 upload: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }
}
