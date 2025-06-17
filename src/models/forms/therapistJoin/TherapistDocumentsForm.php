<?php

namespace app\models\forms\therapistJoin;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\services\FieldRulesService;

class TherapistDocumentsForm extends Model
{
    public $education_file;
    public $additional_certification_file;
    public $education_file_path;
    public $additional_certification_file_path;
    public $photo;

    public function rules()
    {
        return array_merge(
            [
                ['education_file', 'photo'],
                'required'
            ],
            FieldRulesService::education_fileRules(),
            FieldRulesService::additional_certification_fileRules(),
            FieldRulesService::photoRules()
        );
    }

    public function loadUploadedFiles()
    {
        $this->education_file = UploadedFile::getInstance($this, 'education_file');
        $this->additional_certification_file = UploadedFile::getInstance($this, 'additional_certification_file');
        $this->education_file_path = $this->education_file?->tempName;
        $this->additional_certification_file_path = $this->additional_certification_file?->tempName;
    }


    public function uploadToS3(): array|false
    {
        $s3 = Yii::$app->get('s3Storage');
        if (!$s3 || !$s3->client) {
            Yii::error('S3 клієнт не ініціалізовано', 'therapist-join');
            return false;
        }

        $userId = Yii::$app->user->id;
        $directory = "users/{$userId}/documents";
        $photo_directory = "users/{$userId}/photo";

        $result = [];

        try {
            if ($this->education_file_path && file_exists($this->education_file_path)) {
                $result['education_file'] = $s3->upload(
                    $this->education_file_path,
                    $directory . '/education/' . time() . '_' . basename($this->education_file_path)
                );
                unlink($this->education_file_path);
            }

            if ($this->additional_certification_file_path && file_exists($this->additional_certification_file_path)) {
                $result['additional_certification_file'] = $s3->upload(
                    $this->additional_certification_file_path,
                    $directory . '/additional_certification/' . time() . '_' . basename($this->additional_certification_file_path)
                );
                unlink($this->additional_certification_file_path);
            }

            if ($this->photo && file_exists($this->photo)) {
                $result['photo'] = $s3->upload(
                    $this->photo,
                    $photo_directory . '/' . time() . '_' . basename($this->photo)
                );
                unlink($this->photo);
            }
            return [
                'education_file' => $result['education_file']['name'] ?? null,
                'education_file_url' => $result['education_file']['url'] ?? null,
                'additional_certification_file' => $result['additional_certification_file']['name'] ?? null,
                'additional_certification_file_url' => $result['additional_certification_file']['url'] ?? null,
                'photo' => $result['photo']['name'] ?? null,
                'photo_url' => $result['photo']['url'] ?? null,
            ];
        } catch (\Throwable $e) {
            Yii::error('Помилка завантаження на S3: ' . $e->getMessage(), 'therapist-join');
            return false;
        }
    }
}
