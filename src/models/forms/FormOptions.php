<?php

namespace app\models\forms;

/**
 * FormOptions містить всі опції для селектів та чекбоксів, які використовуються в формах
 */
class FormOptions
{
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
            'Kyiv' => 'Kyiv',
            'lviv' => 'Lviv',
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
            'group' => 'Group',
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
        ];
    }

    /**
     * Отримати опції для типів підходів
     * @return array
     */
    public static function getApproachTypeOptions()
    {
        return [
            'CBT' => 'Cognitive Behavioral Therapy (CBT)',
            'Gestalt' => 'Gestalt Therapy',
            'psychoanalyst' => 'Psychoanalyst',
            'cognitive_behavioral_therapy' => 'Cognitive Behavioral Therapy',
            'art_therapy' => 'Art Therapy',
            'gestalt_therapy' => 'Gestalt Therapy',
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
            'both' => 'Not matter',
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