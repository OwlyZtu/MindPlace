<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'SignupBread');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="body-content container-fluid row row-gap-2 justify-content-center">
        <div class="row justify-content-center gradient-text-alt">
            <div class="col-lg-7 text-center">
                <h1><?= Yii::t('app', 'Signup title'); ?></h1>
                <p><?= Yii::t('app', 'Signup please...'); ?></p>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="row my-3">
                    <div class="col-lg-12">

                        <?php $form = ActiveForm::begin([
                            'id' => 'signup-form',
                            'fieldConfig' => [
                                'template' => "{label}\n{input}\n{error}",
                                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?= $form->field($model, 're_password')->passwordInput() ?>
                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-lg-5">
                            <?= Html::submitButton('Create an account', ['class' => 'btn btn-primary btn-lg me-2', 'name' => 'signup-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="row mt-4">
                        <p>
                            Already have an account? <?= Html::a('Log in instead', ['site/login']) ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>