<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\forms\FilterForm;
use app\models\forms\AssignForm;
use app\models\forms\RatingForm;
use yii\data\ActiveDataProvider;

class SpecialistController extends Controller
{
    /**
     * Displays specialists page with optional filtering.
     * @return string
     */
    public function actionIndex()
    {
        $model = new FilterForm();

        if (Yii::$app->request->get('clear')) {
            Yii::$app->session->remove('filterData');
            return $this->redirect(['specialists/index']);
        }

        $filterData = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->saveFilterToSession()) {
                $filterData = FilterForm::getSessionFilter();
            }
        } else {
            $filterData = FilterForm::getSessionFilter();
            if (empty($filterData)) {
                $filterData = ['role' => 'specialist'];
            }
        }

        $query = User::find()->where(['role' => 'specialist']);

        if (!empty($filterData['city'])) {
            $query->andWhere(['city' => $filterData['city']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'model' => $model,
            'filter' => $filterData,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View single specialist profile
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $specialist = User::findOne(['id' => $id, 'role' => 'specialist']);
        if (!$specialist) {
            throw new NotFoundHttpException("Спеціаліста не знайдено.");
        }

        return $this->render('view', [
            'model' => $specialist,
            'assignForm' => new AssignForm(),
            'ratingForm' => new RatingForm(),
        ]);
    }

    /**
     * Assign to a consultation (date + time), leave rating or complaint.
     * @param int $id
     * @return \yii\web\Response|string
     * @throws NotFoundHttpException
     */
    public function actionAssign($id)
    {
        $specialist = User::findOne(['id' => $id, 'role' => 'specialist']);
        if (!$specialist) {
            throw new NotFoundHttpException("Спеціаліста не знайдено.");
        }

        $assignForm = new AssignForm();
        $ratingForm = new RatingForm();

        if ($assignForm->load(Yii::$app->request->post()) && $assignForm->validate()) {
            // Запис на консультацію
            $assignForm->user_id = Yii::$app->user->id;
            $assignForm->specialist_id = $id;
            $assignForm->save();

            Yii::$app->session->setFlash('success', 'Ви записались на консультацію.');
            return $this->redirect(['specialist/view', 'id' => $id]);
        }

        if ($ratingForm->load(Yii::$app->request->post()) && $ratingForm->validate()) {
            // Оцінка спеціаліста
            $ratingForm->user_id = Yii::$app->user->id;
            $ratingForm->specialist_id = $id;
            $ratingForm->save();

            Yii::$app->session->setFlash('success', 'Ваш відгук збережено.');
            return $this->redirect(['specialist/view', 'id' => $id]);
        }

        return $this->render('view', [
            'model' => $specialist,
            'assignForm' => $assignForm,
            'ratingForm' => $ratingForm,
        ]);
    }
}
