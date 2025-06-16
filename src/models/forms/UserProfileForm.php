<?php
namespace app\models\forms;

use yii\base\Model;

class UserProfileForm extends Model
{
    public $birth_date; // тут дата народження

    public function rules()
    {
        return [
            ['birth_date', 'date', 'format' => 'php:Y-m-d', 'skipOnEmpty' => false, 'message' => 'Введіть коректну дату'],
        ];
    }
}
