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

    public function load($data, $formName = null): bool
    {
        $formName = $formName ?? $this->formName();
        $success = parent::load($data, $formName);

        $data = $data[$formName] ?? $data;

        $success = $this->personalInfo->load($data['personalInfo'] ?? [], '') && $success;
        $success = $this->education->load($data['education'] ?? [], '') && $success;
        $success = $this->documents->load($data['documents'] ?? [], '') && $success;
        $success = $this->approaches->load($data['approaches'] ?? [], '') && $success;

        return $success;
    }


    public function getFormData()
    {
        return array_merge(
            Yii::$app->session->get('therapistPersonalInfoForm')?->attributes ?? [],
            Yii::$app->session->get('therapistApproachesForm')?->attributes ?? [],
            Yii::$app->session->get('therapistEducationForm')?->attributes ?? [],
            Yii::$app->session->get('therapistDocumentsForm') ?? []
        );
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
