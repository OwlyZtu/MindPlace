<?php

namespace app\models\forms;
use Yii;

/**
 * FormOptions містить всі опції для селектів та чекбоксів, які використовуються в формах
 */
class FormOptions
{
    protected static array $optionsMap = [
        'format' => 'getFormatOptions',
        'city' => 'getCityOptions',
        'therapy_types' => 'getTherapyTypesOptions',
        'theme' => 'getThemeOptions',
        'approach_type' => 'getApproachTypeOptions',
        'language' => 'getLanguageOptions',
        'gender' => 'getGenderOptions',
        'age' => 'getAgeOptions',
        'specialization' => 'getSpecializationOptions',
        'yesno' => 'getYesNoOptions',
    ];

    public static function getLabel(string $category, string $key): ?string
    {
        $method = static::$optionsMap[$category] ?? null;
        if ($method && method_exists(static::class, $method)) {
            $options = static::$method();
            return $options[$key] ?? null;
        }
        return null;
    }

    /**
     * Отримати опції для формату терапії
     * @return array
     */
    public static function getFormatOptions()
    {
        return [
            'online' => 'Online',
            'offline' => 'Offline',
        ];
    }

    /**
     * Отримати опції для міст
     * @return array
     */
    public static function getCityOptions()
    {
        return [
            'kyiv' => Yii::t('form-options', 'kyiv'),
            'lviv' => Yii::t('form-options', 'lviv'),
            'kharkiv' => Yii::t('form-options', 'kharkiv'),
            'dnipro' => Yii::t('form-options', 'dnipro'),
            'odesa' => Yii::t('form-options', 'odesa'),
            'ivano-frankivsk' => Yii::t('form-options', 'ivano-frankivsk'),
            'zaporizhzhya' => Yii::t('form-options', 'zaporizhzhya'),
            'ternopil' => Yii::t('form-options', 'ternopil'),
            'kherson' => Yii::t('form-options', 'kherson'),
            'khmelnytskyi' => Yii::t('form-options', 'khmelnytskyi'),
            'cherkasy' => Yii::t('form-options', 'cherkasy'),
            'chernihiv' => Yii::t('form-options', 'chernihiv'),
            'chernivtsi' => Yii::t('form-options', 'chernivtsi'),
            'sumy' => Yii::t('form-options', 'sumy'),
        ];
    }

    /**
     * Отримати опції для типів терапії
     * @return array
     */
    public static function getTherapyTypesOptions()
    {
        return [
            'individual' => Yii::t('form-options', 'individual'),
            'couples' => Yii::t('form-options', 'couples'),
            'couching' => Yii::t('form-options', 'couching'),
            'child' => Yii::t('form-options', 'child'),
            'teen' => Yii::t('form-options', 'teen'),
        ];
    }


    /**
     * Отримати опції для тем
     * @return array
     */
    public static function getThemeOptions()
    {
        return [
            'depression' => Yii::t('form-options', 'depression'),
            'stress' => Yii::t('form-options', 'stress'),
            'anxiety' => Yii::t('form-options', 'anxiety'),
            'relationships' => Yii::t('form-options', 'relationships'),
            'self-esteem' => Yii::t('form-options', 'self-esteem'),
            'trauma' => Yii::t('form-options', 'trauma'),
            'relationship' => Yii::t('form-options', 'relationship'),
            'parenting' => Yii::t('form-options', 'parenting'),
            'family' => Yii::t('form-options', 'family'),
            'sex' => Yii::t('form-options', 'sex'),
            'loneliness' => Yii::t('form-options', 'loneliness'),
            'professional' => Yii::t('form-options', 'professional'),
            'pregnancy' => Yii::t('form-options', 'pregnancy'),
            'death' => Yii::t('form-options', 'death'),
            'suicide' => Yii::t('form-options', 'suicide'),
            'cheat' => Yii::t('form-options', 'cheat'),
        ];
    }

    /**
     * Отримати опції для типів підходів
     * @return array
     */
    public static function getApproachTypeOptions()
    {
        return [
            'cbt' => Yii::t('form-options', 'cbt'),
            'gestalt' => Yii::t('form-options', 'gestalt'),
            'psychoanalyst' => Yii::t('form-options', 'psychoanalyst'),
            'art' => Yii::t('form-options', 'art'),
        ];
    }

    /**
     * Отримати опції для мов
     * @return array
     */
    public static function getLanguageOptions()
    {
        return [
            'uk' => Yii::t('form-options', 'ukrainian'),
            'en' => Yii::t('form-options', 'english'),
        ];
    }

    /**
     * Отримати опції для статі
     * @return array
     */
    public static function getGenderOptions()
    {
        return [
            'male' => Yii::t('form-options', 'Male'),
            'female' => Yii::t('form-options', 'Female'),
        ];
    }

    /**
     * Отримати опції для віку
     * @return array
     */
    public static function getAgeOptions()
    {
        return [
            '18-25' => '18-25',
            '26-35' => '26-35',
            '36-45' => '36-45',
            '46+' => '46+',
        ];
    }

    /**
     * Отримати опції для спеціалізації
     * @return array
     */
    public static function getSpecializationOptions()
    {
        return [
            'psychologist' => Yii::t('form-options', 'psychologist'),
            'psychotherapist' => Yii::t('form-options', 'psychotherapist'),
            'child_psychologist' => Yii::t('form-options', 'child_psychologist'),
            'counselor' => Yii::t('form-options', 'counselor'),
        ];
    }

    /**
     * Отримати опції для відповідей так/ні
     * @return array
     */
    public static function getYesNoOptions()
    {
        return [
            'yes' => Yii::t('form-options', 'yes'),
            'no' => Yii::t('form-options', 'no'),
        ];
    }
}
