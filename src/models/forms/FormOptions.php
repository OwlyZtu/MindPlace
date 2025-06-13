<?php

namespace app\models\forms;

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
            'kyiv' => 'Kyiv',
            'lviv' => 'Lviv',
            'kharkiv' => 'Kharkiv',
            'dnipro' => 'Dnipro',
            'odesa' => 'Odesa',
            'ivano-frankivsk' => 'Ivano-Frankivsk',
            'zaporizhzhya' => 'Zaporizhzhya',
            'ternopil' => 'Ternopil',
            'kherson' => 'Kherson',
            'khmelnytskyi' => 'Khmelnytskyi',
            'cherkasy' => 'Cherkasy',
            'chernihiv' => 'Chernihiv',
            'chernivtsi' => 'Chernivtsi',
            'sumy' => 'Sumy',
        ];
    }

    /**
     * Отримати опції для типів терапії
     * @return array
     */
    public static function getTherapyTypesOptions()
    {
        return [
            'individual' => 'Individual',
            'couples' => 'Couples',
            'couching' => 'Couching',
            'child' => 'Children (<12 y.o.)',
            'teen' => 'Teens (12-18 y.o.)',
        ];
    }


    /**
     * Отримати опції для тем
     * @return array
     */
    public static function getThemeOptions()
    {
        return [
            'depression' => 'Depression',
            'stress' => 'Stress',
            'anxiety' => 'Anxiety',
            'relationships' => 'Relationships',
            'self-esteem' => 'Self-esteem',
            'trauma' => 'Trauma',
            'relationship' => 'Relationship Issues',
            'parenting' => 'Parenting',
            'family' => 'Family Issues',
            'sex' => 'Sexual Issues',
            'loneliness' => 'Loneliless',
            'professional' => 'Professional self-realization',
            'pregnancy' => 'Pregnancy',
            'death' => 'Grief and loss',
            'suicide' => 'Suicide',
            'cheat' => 'Partner cheat',
        ];
    }

    /**
     * Отримати опції для типів підходів
     * @return array
     */
    public static function getApproachTypeOptions()
    {
        return [
            'cbt' => 'Cognitive Behavioral Therapy (CBT)',
            'gestalt' => 'Gestalt Therapy',
            'psychoanalyst' => 'Psychoanalyst',
            'art' => 'Art Therapy',
            'gestalt' => 'Gestalt Therapy',
        ];
    }

    /**
     * Отримати опції для мов
     * @return array
     */
    public static function getLanguageOptions()
    {
        return [
            'uk' => 'Ukrainian',
            'en' => 'English',
        ];
    }

    /**
     * Отримати опції для статі
     * @return array
     */
    public static function getGenderOptions()
    {
        return [
            'male' => 'Male',
            'female' => 'Female',
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
            'psychologist' => 'Psychologist',
            'psychotherapist' => 'Psychotherapist',
            'child_psychologist' => 'Child Psychologist',
            'counselor' => 'Counselor',
        ];
    }

    /**
     * Отримати опції для відповідей так/ні
     * @return array
     */
    public static function getYesNoOptions()
    {
        return [
            'yes' => 'Yes',
            'no' => 'No',
        ];
    }
}
