<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\SpecialistApplication;
use yii\web\UploadedFile;

class TherapistJoinForm extends Model
{
    private $_applicationStatus;

    /**
     * Ініціалізація моделі
     */
    public function init()
    {
        parent::init();
        if (!Yii::$app->user->isGuest) {
            $this->_applicationStatus = SpecialistApplication::getStatusById(Yii::$app->user->id);
        }
    }

    /**
     * Отримати статус заявки
     * @return mixed
     */
    public function getApplicationStatus()
    {
        return $this->_applicationStatus;
    }

    // Особиста інформація
    public $name;
    public $date_of_birth = '';
    public $city = '';
    public $gender;

    // Контактна інформація
    public $email;
    public $contact_number;
    public $social_media = '';

    // Специфіка терапії
    public $language = [];
    public $therapy_types = [];
    public $theme = [];
    public $approach_type = [];
    public $format = [];
    public $lgbt = false;
    public $military = false;

    // Освіта та досвід
    public $specialization = [];
    public $education_name = '';
    public $education_file;
    public $additional_certification = '';
    public $additional_certification_file;
    public $experience = '';

    // Політика конфіденційності
    public $privacy_policy;

    /**
     * Правила валідації
     * @return array
     */
    public function rules()
    {
        return [
            // Обов'язкові поля
            [
                [
                    'name', 'email', 'contact_number', 'city',
                    'date_of_birth', 'gender', 'language',
                    'therapy_types', 'theme', 'approach_type',
                    'format', 'education_name', 'education_file',
                    'experience',
                ],
                'required'
            ],
            ['email', 'email'],
            ['contact_number', 'string', 'max' => 13],
            ['privacy_policy', 'boolean'],
            ['privacy_policy', 'compare', 'compareValue' => true, 'message' => 'Будь ласка, прийміть Політику конфіденційності'],
            
            // Валідація файлів
            [
                'education_file',
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'pdf, doc, docx',
                'maxSize' => 2 * 1024 * 1024,
                'tooBig' => 'Розмір файлу не може перевищувати 2MB',
                'wrongExtension' => 'Дозволені формати файлів: PDF, DOC, DOCX',
                'message' => 'Будь ласка, завантажте документ'
            ],
            [
                'additional_certification_file',
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'pdf, doc, docx',
                'maxSize' => 2 * 1024 * 1024,
                'tooBig' => 'Розмір файлу не може перевищувати 2MB',
                'wrongExtension' => 'Дозволені формати файлів: PDF, DOC, DOCX'
            ],
            ['education_file', 'validateMimeType'],
            ['additional_certification_file', 'validateMimeType'],
        ];
    }

    /**
     * Валідація MIME-типів файлів
     * @param string $attribute
     * @param array $params
     */
    public function validateMimeType($attribute, $params)
    {
        $file = UploadedFile::getInstance($this, $attribute);
        if ($file) {
            $allowedMimeTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];

            if (!in_array($file->type, $allowedMimeTypes)) {
                $this->addError($attribute, 'Недопустимий тип файлу. Дозволені типи: PDF, DOC, DOCX');
            }

            if ($file->size > 0) {
                try {
                    $content = file_get_contents($file->tempName);
                    if ($content === false) {
                        $this->addError($attribute, 'Помилка читання файлу');
                        return;
                    }
                    
                    $forbidden = ['<?php', '<script', '<iframe'];
                    foreach ($forbidden as $tag) {
                        if (stripos($content, $tag) !== false) {
                            $this->addError($attribute, 'Файл містить недопустимий код');
                            return;
                        }
                    }
                } catch (\Exception $e) {
                    Yii::error('Помилка при перевірці файлу: ' . $e->getMessage(), 'file-validation');
                    $this->addError($attribute, 'Помилка обробки файлу');
                    return;
                }
            }
        }
    }

    /**
     * Оновлення користувача як терапевта
     * @return bool
     */
    public function updateUserAsTherapist()
    {
        if ($this->validate()) {
            $uploadedFiles = $this->uploadToS3();

            if ($uploadedFiles === false) {
                Yii::error('Помилка завантаження файлів на S3', 'therapist-join');
                return false;
            }

            $user = Yii::$app->user->identity;
            if (!$user->id) {
                Yii::error('ID користувача відсутній', 'therapist-join');
                return false;
            }

            SpecialistApplication::updateUserFromTherapistForm($user->id, $this->getAttributes());
            return true;
        }

        Yii::error('Помилка валідації: ' . json_encode($this->getErrors()), 'therapist-join');
        return false;
    }

    /**
     * Перевірка перед валідацією
     * @return bool
     */
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

    /**
     * Завантаження файлів на S3
     * @return array|false
     */
    public function uploadToS3()
    {
        if (!$this->validate()) {
            Yii::error('education_file відсутній в beforeValidate', 'therapist-join');
            return false;
        }

        $s3 = Yii::$app->get('s3Storage');

        if (!$s3 || !$s3->client) {
            Yii::error('S3 клієнт не ініціалізовано коректно', 'therapist-join');
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
                    Yii::error('Помилка завантаження файлу освіти на S3', 'therapist-join');
                    return false;
                }
            }

            if ($this->additional_certification_file instanceof UploadedFile) {
                $certificationFileInfo = $s3->upload($this->additional_certification_file, $directory);
                if (!$certificationFileInfo) {
                    Yii::error('Помилка завантаження файлу сертифікації на S3', 'therapist-join');
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
            Yii::error('Виняток під час завантаження на S3: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }
}
