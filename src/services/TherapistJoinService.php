<?php

namespace app\services;

use Yii;
use yii\web\UploadedFile;
use app\models\forms\therapistJoin\TherapistJoinForm;
use app\models\forms\therapistJoin\TherapistDocumentsForm;

class TherapistJoinService
{
    public function loadStep(string $step)
    {
        $model = Yii::$app->session->get('therapistJoinForm') ?? new TherapistJoinForm();

        switch ($step) {
            case 'personal-info':
                return ['view' => 'therapist-join/_personal_info', 'model' => $model->personalInfo];
            case 'education':
                return ['view' => 'therapist-join/_education', 'model' => $model->education];
            case 'documents':
                return ['view' => 'therapist-join/_documents', 'model' => $model->documents];
            case 'approaches':
                return ['view' => 'therapist-join/_approaches', 'model' => $model->approaches];
            default:
                throw new \InvalidArgumentException('Invalid step: ' . $step);
        }
    }

    public function saveForm($model, string $sessionKey, array $postData)
    {
        if ($model->load($postData) && $model->validate()) {
            Yii::$app->session->set($sessionKey, $model);
            return ['success' => true];
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function saveDocuments(array $postData)
    {
        $model = new TherapistDocumentsForm();

        if ($model->load($postData)) {
            $photoFile = UploadedFile::getInstance($model, 'photo');
            $educationFile = UploadedFile::getInstance($model, 'education_file');
            $additionalFile = UploadedFile::getInstance($model, 'additional_certification_file');


            if ($photoFile) {
                $photoPath = $this->saveUploadedFile($photoFile, 'photo_');
                if (!$photoPath) {
                    return ['success' => false, 'errors' => ['photo' => ['Не вдалося зберегти фото']]];
                }
                $model->photo = $photoPath;
            }
            if ($educationFile) {
                $educationPath = $this->saveUploadedFile($educationFile, 'edu_');
                if (!$educationPath) {
                    return ['success' => false, 'errors' => ['education_file' => ['Не вдалося зберегти файл освіти']]];
                }
                $model->education_file_path = $educationPath;
                $model->education_file = $educationFile;
            }
            if ($additionalFile) {
                $additionalPath = $this->saveUploadedFile($additionalFile, 'cert_');
                if (!$additionalPath) {
                    return ['success' => false, 'errors' => ['additional_certification_file' => ['Не вдалося зберегти сертифікат']]];
                }
                $model->additional_certification_file_path = $additionalPath;
                $model->additional_certification_file = $additionalFile;
            }

            if ($model->validate()) {
                $filesData = $model->uploadToS3();
                Yii::$app->session->set('therapistDocumentsForm', $filesData);
                return ['success' => true];
            } else {
                Yii::error('Validation error', 'therapist-join');
                return ['success' => false, 'errors' => $model->getErrors()];
            }
        }

        return ['success' => false, 'errors' => ['save' => ['Некоректний запит']]];
    }

    public static function saveUploadedFile(UploadedFile $file, string $prefix): ?string
    {
        $fileName = uniqid($prefix) . '.' . $file->extension;
        $filePath = Yii::getAlias('@runtime/uploads/' . $fileName);

        if ($file->saveAs($filePath)) {
            return $filePath;
        }
        return null;
    }

    public function finalSubmit(array $postData): array
    {
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'errors' => ['submit' => ['Неавторизований користувач']]];
        }

        $model = new TherapistJoinForm();

        if (!$model->validate()) {
            Yii::error('Validation errors: ' . json_encode($model->getErrors()), 'therapist-join');
            return ['success' => false, 'errors' => $model->getErrors()];
        }

        if (!$model->updateUserAsTherapist()) {
            Yii::error('Update failed, errors: ' . json_encode($model->getErrors()), 'therapist-join');
            return ['success' => false, 'errors' => $model->getErrors()];
        }

        return ['success' => true];
    }
}
