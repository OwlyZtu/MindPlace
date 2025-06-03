<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class FilterForm extends Model
{
    public $format;
    public $city;
    public $therapy_types;
    public $theme;
    public $approach_type;
    public $language;
    public $gender;
    public $age;
    public $specialization;
    public $lgbt;
    public $military;

    /**
     * Повертає дані фільтра
     * @return array|false
     */
    public function getFilterData()
    {
        if ($this->validate()) {
            Yii::info('validate success');
            //($this->format !== 'offline') ?: ($this->city = null);
            return [
                'format' => $this->format,
                'city' => $this->city,
                'therapy_types' => $this->therapy_types,
                'theme' => $this->theme,
                'approach_type' => $this->approach_type,
                'language' => $this->language,
                'gender' => $this->gender,
                'age' => $this->age,
                'specialization' => $this->specialization,
                'lgbt' => $this->lgbt,
                'military' => $this->military,
            ];
        }
        Yii::error('validate fail');
        return false;
    }

    /**
     * Зберігає дані фільтра в сесію
     * @return array|bool
     */
    public function saveFilterToSession()
    {
        $filterData = $this->getFilterData();
        Yii::$app->session->set('filterData', $filterData);
        return $filterData !== false;
    }

    /**
     * Отримати дані фільтра з сесії (filterData або questionnaireData)
     * @return array|null
     */
    public static function getSessionFilter()
    {
        $session = Yii::$app->session;
        return $session->get('filterData') ?: $session->get('questionnaireData');
    }

    public function rules()
    {
        return [
            [['format', 'city', 'gender', 'age'], 'safe'],
            [['therapy_types', 'theme', 'approach_type', 'language', 'specialization'], 'safe'],
            [['lgbt', 'military'], 'boolean'],
        ];
    }
}
