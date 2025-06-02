<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\admin\UserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

class UsersController extends Controller
{
    public $layout = 'admin';

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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'block' => ['post'],
                    'approve' => ['post'],
                    'reject' => ['post'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Дані терапевта оновлено успішно.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Терапевта видалено успішно.');
        return $this->redirect(['index']);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('status', 'approved');
        $model->setAttribute('updated_at', Yii::$app->user->id);
        if ($model->getAttribute('review_date') === null) 
        {
            $model->setAttribute('review_date', date('Y-m-d H:i:s'));
        }
        $model->setAttribute('admin_id', Yii::$app->user->id);

        if ($model->save()) {
            Yii::info(
                "Адміністратор" . Yii::$app->user->identity->name . "підтвердив терапевта" . $model->name,
                'admin.therapist'
            );
            Yii::$app->session->setFlash('success', 'Терапевта підтверджено успішно.');
        } else {
            Yii::$app->session->setFlash('error', 'Помилка при підтвердженні терапевта.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('status', 'rejected');
        $model->setAttribute('updated_at', Yii::$app->user->id);
        if ($model->getAttribute('review_date') === null) 
        {
            $model->setAttribute('review_date', date('Y-m-d H:i:s'));
        }
        $model->setAttribute('admin_id', Yii::$app->user->id);

        if ($model->save()) {
            Yii::info(
                "Адміністратор" . Yii::$app->user->identity->name . "відхилив терапевта" . $model->name,
                'admin.therapist'
            );
            Yii::$app->session->setFlash('success', 'Терапевта відхилено.');
        } else {
            Yii::$app->session->setFlash('error', 'Помилка при відхиленні терапевта.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDownload($file)
    {
        $filePath = Yii::getAlias('@app/uploads/') . $file;
        if (file_exists($filePath)) {
            Yii::info(
                "Адміністратор" . Yii::$app->user->identity->name . "завантажив файл " . $file,
                'admin.therapist'
            );
            return Yii::$app->response->sendFile($filePath);
        }
        throw new NotFoundHttpException('Файл не знайдено.');
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запитаного терапевта не знайдено.');
    }
}
