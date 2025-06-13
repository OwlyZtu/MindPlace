<?php

namespace app\models\forms\therapistJoin;

use Yii;
use yii\base\Model;
use app\models\SpecialistApplication;

use app\models\forms\therapistJoin\TherapistPersonalInfoForm;
use app\models\forms\therapistJoin\TherapistEducationForm;
use app\models\forms\therapistJoin\TherapistDocumentsForm;
use app\models\forms\therapistJoin\TherapistApproachesForm;

class TherapistJoinForm extends Model
{
    public $personalInfo;
    public $education;
    public $documents;
    public $approaches;
    private $_applicationStatus;


    /**
     * @return mixed
     */
    public function getApplicationStatus()
    {
        return $this->_applicationStatus;
    }


    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->personalInfo = new TherapistPersonalInfoForm();
        $this->education = new TherapistEducationForm();
        $this->documents = new TherapistDocumentsForm();
        $this->approaches = new TherapistApproachesForm();
        if (!Yii::$app->user->isGuest) {
            $this->_applicationStatus = SpecialistApplication::getStatusById(Yii::$app->user->id);
        }
    }

    public function rules()
    {
        return [
            [['personalInfo', 'education', 'documents', 'approaches'], 'safe'],
        ];
    }


    public function getFormData()
    {
        $formData = [];
        $personalInfo = Yii::$app->session->get('therapistPersonalInfoForm');
        $approaches = Yii::$app->session->get('therapistApproachesForm');
        $education = Yii::$app->session->get('therapistEducationForm');
        $documents = Yii::$app->session->get('therapistDocumentsForm');

        $formData = array_merge(
            $personalInfo ? $personalInfo->attributes : [],
            $approaches ? $approaches->attributes : [],
            $education ? $education->attributes : [],
            $documents? $documents : []
        );
        return $formData;
    }
    /**
     * Update user as therapist
     * @return bool
     */
    public function updateUserAsTherapist()
    {
    
        $formData = $this->getFormData();
        
        if (!$this->validate()) {
            Yii::error('Загальна валідація не пройдена: ' . json_encode($this->getErrors()), 'therapist-join');
            return false;
        }
    
        $user = Yii::$app->user->identity;
        if (!$user || !$user->id) {
            Yii::error('ID користувача відсутній', 'therapist-join');
            return false;
        }
    
        SpecialistApplication::updateUserFromTherapistForm($user->id, $formData);
        return true;
    }
    
}
