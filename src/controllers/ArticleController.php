<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Article;
use yii\data\ActiveDataProvider;
use app\models\forms\ArticleForm;

class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'specialist-articles', 'create-article', 'update-article', 'delete-article'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['specialist-articles', 'create-article', 'update-article', 'delete-article'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isSpecialist();
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }

        if ($lang = Yii::$app->session->get('language')) {
            Yii::$app->language = $lang;
        }

        return parent::beforeAction($action);
    }

    /**
     * Sets the language for the application.
     *
     * @param string $lang The language code (e.g., 'uk', 'en').
     */
    public function actionSetLanguage($lang)
    {
        if (in_array($lang, ['uk', 'en'])) {
            Yii::$app->session->set('language', $lang);
            Yii::$app->language = $lang;
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::getAllApproved(),
            'pagination' => ['pageSize' => 6],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSpecialistArticles()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Article::getAllByDoctor(Yii::$app->user->identity->id),
            'pagination' => ['pageSize' => 6],
        ]);
        return $this->render('specialist-articles', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = Article::getById($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreateArticle()
    {
        if (!Yii::$app->user->identity->isSpecialist()) {
            throw new NotFoundHttpException('У вас немає доступу до створення статті.');
        }

        $model = new ArticleForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($article = $model->save()) {
                Yii::$app->session->setFlash('success', 'Стаття створена успішно.');
                return $this->redirect(['view', 'id' => $article->id]);
            } else {
                Yii::error($model->getErrors(), 'article-create');
                Yii::$app->session->setFlash('error', 'Не вдалося зберегти статтю.');
            }
        }

        return $this->render('create-article', [
            'model' => $model,
        ]);
    }


    public function actionUpdateArticle($id)
    {
        $article = Article::getById($id);
        if (
            $article->doctor_id !== Yii::$app->user->identity->id
            && !Yii::$app->user->identity->isAdmin()
        ) {
            throw new NotFoundHttpException('У вас немає доступу до редагування цієї статті.');
        }
        $model = new ArticleForm();
        $model->loadFromModel($article);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = Article::STATUS_REVIEWING;
            if ($article = $model->save()) {
                Yii::$app->session->setFlash('success', 'Стаття оновлена успішно.');
                return $this->redirect(['view', 'id' => $article->id]);
            } else {
                Yii::error($model->getErrors(), 'article-update');
                Yii::$app->session->setFlash('error', 'Не вдалося оновити статтю.');
            }
        }

        return $this->render('update-article', [
            'model' => $model,
            'article' => $article,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Article::getById($id);

        if (
            $model->doctor_id !== Yii::$app->user->identity->id
            && !Yii::$app->user->identity->isAdmin()
        ) {
            throw new NotFoundHttpException('У вас немає доступу до видалення цієї статті.');
        }

        $model->delete();
        return $this->redirect(['index']);
    }
}
