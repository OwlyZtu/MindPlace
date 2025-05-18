<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class UsersController extends Controller
{
    public $layout = 'admin';
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Displays a single therapist.
     * @param int $id therapist ID 
     * @return string
     * @throws NotFoundHttpException if the therapist is not found
     */
    public function actionView($id)
    {
        $jsonFilePath = Yii::getAlias('@app/data/test_doctors.json');
        $doctor = null;
        
        if (file_exists($jsonFilePath)) {
            $doctorsData = json_decode(file_get_contents($jsonFilePath), true);
            foreach ($doctorsData as $doctorData) {
                if ($doctorData['id'] == $id) {
                    $doctor = new User();
                    foreach ($doctorData as $attribute => $value) {
                        $doctor->$attribute = $value;
                    }
                    break;
                }
            }
        }
        
        if ($doctor === null) {
            throw new NotFoundHttpException('Запитаного лікаря не знайдено.');
        }
        
        return $this->render('view', [
            'doctor' => $doctor,
        ]);
    }
    

    public function actionApprove($id)
    {
        Yii::$app->session->setFlash('success', 'Лікаря успішно підтверджено.');
        return $this->goBack();
    }
    
    public function actionReject($id)
    {
        Yii::$app->session->setFlash('success', 'Лікаря відхилено.');
        return $this->goBack();
    }
    
    public function actionDownload($file)
    {
        $filePath = Yii::getAlias('@app/uploads/') . $file;
        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath);
        } else {
            throw new NotFoundHttpException('Файл не знайдено.');
        }
    }
}