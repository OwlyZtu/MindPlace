<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\forms\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'SignupBread');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="col-lg-6 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
            <div class="row justify-content-center gradient-text">

                <div class="col-lg-7 text-center">
                    <h1>
                        <?= Yii::t('app', 'Signup title'); ?>
                        <span>
                            <svg width="40" hight="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <circle cx="10" cy="6" r="4" stroke="#437576" stroke-width="1.5"></circle>
                                    <path d="M21 10H19M19 10H17M19 10L19 8M19 10L19 12" stroke="#437576" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M17.9975 18C18 17.8358 18 17.669 18 17.5C18 15.0147 14.4183 13 10 13C5.58172 13 2 15.0147 2 17.5C2 19.9853 2 22 10 22C12.231 22 13.8398 21.8433 15 21.5634" stroke="#437576" stroke-width="1.5" stroke-linecap="round"></path>
                                </g>
                            </svg>
                        </span>
                    </h1>
                    <p><?= Yii::t('app', 'Signup please...'); ?></p>
                </div>
            </div>


            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="row my-3 justify-content-center">
                        <div class="col-lg-9 w-100">

                            <?php $form = ActiveForm::begin([
                                'id' => 'signup-form',
                                'fieldConfig' => [
                                    'template' => "{label}\n{input}\n{error}",
                                    'labelOptions' => ['class' => 'col-lg-4 col-form-label mr-lg-3'],
                                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                                ],
                            ]); ?>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true])
                                ->label(Yii::t('app', 'Form name')); ?>

                            <?= $form->field($model, 'email')->label(Yii::t('app', 'Form email')) ?>

                            <?= $form->field($model, 'contact_number')->label(Yii::t('app', 'Form phone')) ?>

                            <?= $form->field($model, 'date_of_birth')->input('date')->label(Yii::t('app', 'Date of birth')) ?>

                            <?= $form->field($model, 'password')->passwordInput()
                                ->label(Yii::t('app', 'Form password')); ?>

                            <?= $form->field($model, 're_password')->passwordInput()
                                ->label(Yii::t('app', 'Form password repeat')) ?>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-lg-6 text-center">
                                <?= Html::submitButton(
                                    Yii::t('app', 'Signup submit'),
                                    ['class' => 'btn btn-primary btn-lg me-2', 'name' => 'signup-button']
                                ) ?>
                            </div>
                            <div class="col-lg-6 text-center">
                                <a href="<?= \yii\helpers\Url::to(['site/auth-google']) ?>" class="btn btn-danger">
                                    Увійти через Google
                                </a>
                            </div>

                        </div>

                        <?php ActiveForm::end(); ?>

                        <div class="row mt-4 text-center">
                            <p>
                                <?= Yii::t('app', 'Form or login') ?>
                                <?= Html::a(Yii::t('app', 'Link to login'), ['site/login']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>