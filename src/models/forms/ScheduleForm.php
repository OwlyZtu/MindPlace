<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Schedule;
use DateTime;

/**
 * ScheduleForm — форма для створення запису розкладу.
 */
class ScheduleForm extends Model
{
    public $datetime;
    public $duration;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['datetime', 'duration'], 'required'],
            ['datetime', 'filter', 'filter' => 'strval'],
            ['datetime', 'datetime', 'format' => 'php:Y-m-d\TH:i'],
            ['datetime', 'validateDateNotPast'],
            ['duration', 'integer', 'min' => 15, 'max' => 180],
        ];
    }

    /**
     * Валідація, що обрана дата не в минулому
     */
    public function validateDateNotPast($attribute, $params)
    {
        $inputTime = strtotime($this->$attribute);
        if ($inputTime < time()) {
            $this->addError($attribute, 'Дата і час не можуть бути в минулому.');
        }
    }
    /**
     * Збереження розкладу для поточного користувача
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $schedule = new Schedule();
        $schedule->doctor_id = Yii::$app->user->identity->id;
        $schedule->datetime = $this->datetime;
        $schedule->duration = $this->duration;
        $schedule->session_id = null;

        return $schedule->save(false);
    }
}
