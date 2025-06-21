<?php

namespace app\models\forms;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\User;
use app\services\FieldRulesService;
use app\services\TherapistJoinService;


/**
 * @property-read User|null $user
 */
class UserSettingsForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $re_password;
    public $contact_number;
    public $date_of_birth;

    // Додаткові поля лікаря
    public $therapy_types = [];
    public $format = [];
    public $specialization = [];
    public $experience = '';
    public $approach_type = [];

    public $photo;
    public $additional_certification_file = [];

    // pseudo
    public $education_file_url;

    // Поля для визначення заблокованих значень
    public $existing_therapy_types = [];
    public $existing_format = [];
    public $existing_specialization = [];
    public $existing_approach_type = [];

    public function rules()
    {
        $rules = array_merge(
            FieldRulesService::nameRules(),
            [
                ['email', 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                    $currentUser = Yii::$app->user->identity;
                    if ($currentUser) {
                        $query->andWhere(['!=', 'id', $currentUser->id]);
                    }
                }],
            ],
            FieldRulesService::contactNumberRules(),
            FieldRulesService::date_of_birthRules(),
            FieldRulesService::additional_certification_fileRules(),
            FieldRulesService::photoRules(),
            [
                ['password', 'string', 'min' => 6],
                ['re_password', 'compare', 'compareAttribute' => 'password'],

                [['therapy_types', 'format', 'specialization', 'approach_type'], 'each', 'rule' => ['string']],
                ['experience', 'string'],

            ]
        );
        return $rules;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Імʼя',
            'email' => 'Email',
            'contact_number' => 'Номер телефону',
            'date_of_birth' => 'Дата народження',
            'password' => 'Новий пароль',
            're_password' => 'Повтор паролю',
            'therapy_types' => 'Типи терапії',
            'format' => 'Формат',
            'specialization' => 'Спеціалізація',
            'experience' => 'Досвід',
            'approach_type' => 'Підходи у роботі',
            'photo' => 'Фото профілю',
            'additional_certification_file' => 'Додаткові сертифікати',
            'education_file_url' => 'Документ про освіту',
        ];
    }

    public function userUpdateSettingsForm()
    {
        if (!$this->validate()) {
            return false;
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'date_of_birth' => $this->date_of_birth,
            'therapy_types' => $this->therapy_types,
            'format' => $this->format,
            'specialization' => $this->specialization,
            'experience' => $this->experience,
            'approach_type' => $this->approach_type,
        ];

        if (!empty($this->password) && !empty($this->re_password)) {
            $data['password'] = $this->password;
            $data['re_password'] = $this->re_password;
        }

        if (!empty($this->photo) || !empty($this->additional_certification_file)) {
            $result = $this->uploadToS3();
            if ($result) {
                $data['photo'] = $result['photo'];
                $data['photo_url'] = $result['photo_url'];
                $data['additional_certification_file'] = $result['additional_certification_file']?? null;
                $data['additional_certification_file_url'] = $result['additional_certification_file_url']?? null;
            } else {
                Yii::error('Помилка завантаження файлів на S3', 'file_change');
                return false;
            }
        }
        if (User::userUpdateSettings($data)) {
            Yii::$app->session->setFlash('success', 'Дані успішно оновлені.');
            return true;
        }
    }

    public function uploadToS3(): array|false
    {
        $s3 = Yii::$app->get('s3Storage');
        if (!$s3 || !$s3->client) {
            Yii::error('S3 клієнт не ініціалізовано', 'file_change');
            return false;
        }

        $userId = Yii::$app->user->id;
        $directory = "users/{$userId}/documents";
        $photo_directory = "users/{$userId}/photo";

        $result = [];

        try {
            if (!empty($this->additional_certification_file)) {
                foreach ($this->additional_certification_file as $file) {
                    $tempPath = TherapistJoinService::saveUploadedFile($file, 'cert_');
                    if ($tempPath) {
                        $uploadResult = $s3->upload(
                            $tempPath,
                            $directory . '/additional_certification/' . time() . '_' . $file->name
                        );
                        $result['additional_certification_file'][] = $uploadResult['name'] ?? null;
                        $result['additional_certification_file_url'][] = $uploadResult['url'] ?? null;
                        unlink($tempPath);
                    }
                } 
            }

            if ($this->photo instanceof UploadedFile) {
                $tempPath = TherapistJoinService::saveUploadedFile($this->photo, 'photo_');
                if ($tempPath) {
                    $uploadResult = $s3->upload(
                        $tempPath,
                        $photo_directory . '/' . time() . '_' . $this->photo->name
                    );
                    $result['photo'] = $uploadResult['name'] ?? null;
                    $result['photo_url'] = $uploadResult['url'] ?? null;
                    unlink($tempPath);
                }
            }

            return $result;
        } catch (\Throwable $e) {
            Yii::error('Помилка завантаження на S3: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }

    public function loadUserData(User $user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
        $this->contact_number = $user->contact_number;
        $this->date_of_birth = $user->date_of_birth;

        $this->therapy_types = json_decode($user->therapy_types ?? '[]', true);
        $this->format = json_decode($user->format ?? '[]', true);
        $this->specialization = json_decode($user->specialization ?? '[]', true);
        $this->experience = json_decode($user->experience ?? '', true);
        $this->approach_type = json_decode($user->approach_type ?? '[]', true);

        $this->existing_therapy_types = $this->therapy_types;
        $this->existing_format = $this->format;
        $this->existing_specialization = $this->specialization;
        $this->existing_approach_type = $this->approach_type;

        $this->education_file_url = $user->education_file ?? null;
    }

    public function beforeValidate()
    {
        $this->photo = UploadedFile::getInstance($this, 'photo');
        $this->additional_certification_file = UploadedFile::getInstances($this, 'additional_certification_file');
        return parent::beforeValidate();
    }
}
