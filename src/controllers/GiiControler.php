<?php

namespace app\controllers;

use yii\filters\AccessControl;
use Yii;
use yii\web\Controller;

class GiiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'login']
                    ],

                ],
                // 'rules' => [
                //     [
                //         'actions' => ['login'],
                //         'allow' => true,
                //         'roles' => ['?'],
                //     ],
                //     [
                //         'actions' => ['index'],
                //         'allow' => true,
                //         'roles' => ['@'],
                //         'matchCallback' => function ($rule, $action) {
                //             return Yii::$app->user->identity->isAdmin();
                //         }
                //     ],
                // ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (Yii::$app->user->isGuest) {
            $model = new \yii\base\DynamicModel(['password']);
            if ($model->load(Yii::$app->request->post()) && $model->password === 'adminSofiia') {
                $identityClass = Yii::$app->user->identityClass;
                $identity = $identityClass::findIdentity(1);
                if ($identity) {
                    Yii::$app->user->login($identity);
                    return $this->redirect(['index']);
                }
            }

            return $this->render('login', ['model' => $model]);
        }

        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        return $this->render('index');
    }
}
