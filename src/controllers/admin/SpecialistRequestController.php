<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AdminController;
use app\models\SpecialistApplication;
use yii\filters\AccessControl;

use yii\web\NotFoundHttpException;
use app\models\admin\UserSearch;
use yii\data\ActiveDataProvider;
use app\models\User;

class SpecialistRequestController extends AdminController
{
    public $enableCsrfValidation = true;
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
                        'actions' => [
                            'index',
                            'view',
                            'download',
                            'download-education',
                            'download-additional-certification',
                            'approve',
                            'reject',
                            'block'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isModerator());
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $statuses = [
            SpecialistApplication::STATUS_PENDING,
            SpecialistApplication::STATUS_APPROVED,
            SpecialistApplication::STATUS_REJECTED,
            SpecialistApplication::STATUS_BLOCKED,
        ];
        $providers = [];
        $searchModel = [];

        foreach ($statuses as $status) {
            $searchModel = new UserSearch();
            $searchModel->status = $status;
    
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize = 5;
    
            $providers[$status] = $dataProvider;
            $searchModels[$status] = $searchModel;
        }

        return $this->render('index', [
            'providers' => $providers,
            'searchModels' => $searchModels,
        ]);
    }

    public function actionView($id)
    {
        $application = $this->findModel($id);
        $user = $application->user;
        return $this->render('view', [
            'doctor' => $user,
            'application' => $application,
        ]);
    }

    public function actionDownload($file)
    {
        $s3 = Yii::$app->get('s3Storage');
        if (!$s3 || !$s3->client) {
            Yii::error('S3 клієнт не ініціалізовано', 'therapist-join');
            Yii::$app->session->setFlash('error', 'Сховище недоступне.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        try {
            $key = $this->extractKeyFromUrl($file); // тут ми беремо повний шлях

            $result = $s3->getClient()->getObject([
                'Bucket' => $s3->bucket,
                'Key' => $key,
            ]);

            $stream = $result['Body']->detach();
            $filename = basename($key);

            return Yii::$app->response->sendStreamAsFile($stream, $filename);
        } catch (\Exception $e) {
            Yii::error("Download error: " . $e->getMessage(), 'admin.download');
            Yii::$app->session->setFlash('error', 'Не вдалося завантажити файл.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionDownloadEducation($id)
    {
        $user = User::findOne($id);
        if (!$user || !$user->education_file_url) {
            throw new NotFoundHttpException("Файл не знайдено.");
        }

        return $this->actionDownload($user->education_file_url);
    }

    public function actionDownloadAdditionalCertification($id)
    {
        $user = User::findOne($id);
        if (!$user || !$user->additional_certification_file_url) {
            throw new NotFoundHttpException("Файл не знайдено.");
        }

        return $this->actionDownload($user->additional_certification_file_url);
    }

    protected function extractKeyFromUrl(string $url): string
    {
        $parsed = parse_url($url);
        return ltrim($parsed['path'], '/');
    }


    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $comment = Yii::$app->request->post('comment');

        $model->status = SpecialistApplication::STATUS_APPROVED;
        if (!empty($comment)) {
            $model->comment = $comment;
        }

        if ($model->save()) {
            User::updateUser($model->user_id, ['status' => 'specialist']);
            Yii::$app->session->setFlash('success', 'Заявку підтверджено.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти зміни.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }



    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $comment = Yii::$app->request->post('comment');

        $model->status = SpecialistApplication::STATUS_REJECTED;
        if (!empty($comment)) {
            $model->comment = $comment;
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Заявку відхилено.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти зміни.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }


    public function actionBlock($id)
    {
        $model = $this->findModel($id);
        $comment = Yii::$app->request->post('comment');

        $model->status = SpecialistApplication::STATUS_BLOCKED;
        if (!empty($comment)) {
            $model->comment = $comment;
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Користувача заблоковано.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти зміни.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionUnblock($id)
    {
        $model = $this->findModel($id);
        $comment = Yii::$app->request->post('comment');

        $model->status = SpecialistApplication::STATUS_PENDING;
        if (!empty($comment)) {
            $model->comment = $comment;
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Користувача розблоковано.');
        } else {
            Yii::$app->session->setFlash('error', 'Не вдалося зберегти зміни.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    protected function findModel($id)
    {
        if (($model = SpecialistApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заявку не знайдено.');
    }
}
