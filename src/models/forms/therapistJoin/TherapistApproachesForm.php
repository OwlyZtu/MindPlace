<?php

namespace app\models\forms\therapistJoin;

use yii\base\Model;

class TherapistApproachesForm extends Model
{
    public $language = [];
    public $therapy_types = [];
    public $theme = [];
    public $approach_type = [];
    public $format = [];
    public $lgbt = false;
    public $military = false;

    public function rules()
    {
        return [
            [
                [
                    'language',
                    'therapy_types',
                    'theme',
                    'approach_type',
                    'format'
                ],
                'required'
            ],
        ];
    }
}
