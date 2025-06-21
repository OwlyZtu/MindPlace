<?php

namespace app\controllers\admin;

use Yii;
use app\controllers\AdminController;
use yii\filters\AccessControl;
use app\models\Article;
use app\models\SpecialistApplication;
use yii\data\ActiveDataProvider;
use app\models\admin\ArticleSearch;



class ArticleReviewController extends AdminController
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
                        'actions' => [
                            'index',
                            'view',
                            'approve',
                            'reject',
                            'redirect-to-specialist'
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
            Article::STATUS_REVIEWING,
            Article::STATUS_APPROVED,
            Article::STATUS_REJECTED,
        ];
        $providers = [];
        $searchModel = [];

        foreach ($statuses as $status) {
            $searchModel = new ArticleSearch();
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
        $article = Article::getById($id);
        if (!$article) {
            Yii::error('Article not found', 'article-review');
            return $this->redirect(['index']);
        }
        return $this->render('view', [
            'article' => $article,
        ]);
    }

    public function actionRedirectToSpecialist($id)
    {
        $specialistApplication = SpecialistApplication::getByUserId($id);
        return $this->redirect(['/admin/specialist-request/view', 'id' => $specialistApplication->id]);
    }

    public function actionApprove($articleId)
    {
        $article = Article::getById($articleId);
        if ($article) {
            if (!$article->updateStatus(Article::STATUS_APPROVED)) {
                Yii::error('Article status update failed', 'article-review');
                Yii::$app->session->setFlash('error', 'Article status update failed');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('success', 'Article approved');
            return $this->redirect(['view', 'id' => $articleId]);
        }
        return $this->redirect(['index']);
    }

    public function actionReject($articleId)
    {
        $article = Article::getById($articleId);
        if ($article) {
            if (!$article->updateStatus(Article::STATUS_REJECTED)) {
                Yii::error('Article status update failed', 'article-review');
                Yii::$app->session->setFlash('error', 'Article status update failed');
                return $this->redirect(['index']);
            }
            Yii::$app->session->setFlash('success', 'Article rejected');
            return $this->redirect(['view', 'id' => $articleId]);
        }
        return $this->redirect(['index']);
    }
}
