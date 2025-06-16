<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class AssignForm extends Model
{
    public $date;
    public $time;
    public $user_id;
    public $specialist_id;

    public function rules()
    {
        return [
            [['date', 'time'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['time'], 'match', 'pattern' => '/^\d{2}:\d{2}$/', 'message' => 'Невірний формат часу'],
            [['user_id', 'specialist_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Дата консультації',
            'time' => 'Час консультації',
        ];
    }

    public function save()
    {
        // Тут потрібно реалізувати логіку збереження запису на консультацію.
        // Наприклад, створити нову модель Appointment або іншу таблицю.

        // Приклад (псевдокод):
        /*
        $appointment = new Appointment();
        $appointment->user_id = $this->user_id;
        $appointment->specialist_id = $this->specialist_id;
        $appointment->date = $this->date;
        $appointment->time = $this->time;
        return $appointment->save();
        */

        // Для прикладу повертаємо true
        return true;
    }
}
