<?php
namespace app\controllers;

use Yii;
use app\models\admin\SpecialistJoinForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SpecialistRequestController extends Controller
{
    public function actionIndex()
    {
        $query = SpecialistJoinForm::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = SpecialistJoinForm::STATUS_APPROVED;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Заявку підтверджено.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти зміни.');
        }

        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = SpecialistJoinForm::STATUS_REJECTED;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Заявку відхилено.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти зміни.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = SpecialistJoinForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заявку не знайдено.');
    }
}
