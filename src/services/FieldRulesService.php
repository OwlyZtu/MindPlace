<?php

namespace app\services;

use Yii;
use yii\base\Model;

class FieldRulesService extends Model
{
    public static function nameRules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'min' => 3, 'max' => 255],
        ];
    }

    public static function emailRules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
        ];
    }

    public static function contactNumberRules()
    {
        return [
            ['contact_number', 'string', 'min' => 10, 'max' => 10],
            ['contact_number', 'match', 'pattern' => '/^[0-9]+$/', 'message' => Yii::t('app', 'Contact number must contain only digits.')],
        ];
    }
    public static function passwordRules()
    {
        return [
            ['password_hash', 'required'],
            ['password_hash', 'string', 'min' => 6],
        ];
    }

    public static function date_of_birthRules()
    {
        return [
            ['date_of_birth', 'date', 'format' => 'php:Y-m-d'],
            ['date_of_birth', function ($attribute, $params) {
                $minAge = 16;
                $value = $this->$attribute;
                if (empty($value)) {
                    return;
                }

                $birthDate = new \DateTime($value);
                $today = new \DateTime();
                $age = $today->diff($birthDate)->y;

                if ($age < $minAge) {
                    $this->addError($attribute, Yii::t('app', 'Ви повинні бути старше {minAge} років', ['minAge' => $minAge]));
                }
            }],
        ];
    }

    public static function auth_keyRules()
    {
        return [
            ['auth_key', 'required'],
            ['auth_key', 'string', 'max' => 32],
        ];
    }

    public static function access_tokenRules()
    {
        return [
            ['access_token', 'required'],
            ['access_token', 'string', 'max' => 255],
        ];
    }

    public static function created_atRules()
    {
        return [
            ['created_at', 'required'],
            ['created_at', 'safe'],
        ];
    }

    public static function roleRules()
    {
        return [
            ['role', 'required'],
            ['role', 'in', 'range' => ['admin', 'default', 'moderator', 'specialist', 'guest']],
        ];
    }

    public static function education_fileRules()
    {
        return [[
            'education_file',
            'file',
            'extensions' => 'pdf, doc, docx',
            'maxSize' => 2 * 1024 * 1024,
            'tooBig' => 'Розмір файлу не може перевищувати 2MB',
            'checkExtensionByMimeType' => false,
            'wrongExtension' => 'Дозволені формати: PDF, DOC, DOCX',
        ]];
    }

    public static function additional_certification_fileRules()
    {
        return [[
            'additional_certification_file',
            'file',
            'extensions' => 'pdf, doc, docx',
            'maxSize' => 2 * 1024 * 1024,
            'tooBig' => 'Розмір файлу не може перевищувати 2MB',
            'checkExtensionByMimeType' => false,
            'wrongExtension' => 'Дозволені формати: PDF, DOC, DOCX',
        ]];
    }

    public static function photoRules()
    {
        return [[
            'photo',
            'image',
            'extensions' => 'jpg, jpeg, png',
            'maxSize' => 1 * 1024 * 1024,
            'tooBig' => 'Розмір файлу не може перевищувати 1MB',
            'checkExtensionByMimeType' => false,
            'wrongExtension' => 'Дозволені формати: JPG, JPEG, PNG',
        ]];
    }
}
