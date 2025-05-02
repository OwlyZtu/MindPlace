<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t('app', 'LoginBread');;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="col-lg-6 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
            <div class="row justify-content-center gradient-text">
                <div class="col-lg-10 text-center mt-2">
                    <h1>
                        <?= Yii::t('app', 'Login title') ?>
                        <span class="text-muted">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <circle cx="10" cy="6" r="4" stroke="#437576" stroke-width="1.5"></circle>
                                    <path d="M18.0429 12.3656L18.4865 11.7609L18.4865 11.7609L18.0429 12.3656ZM19 8.69135L18.4813 9.23307C18.7713 9.51077 19.2287 9.51077 19.5187 9.23307L19 8.69135ZM19.9571 12.3656L19.5135 11.7609L19.5135 11.7609L19.9571 12.3656ZM19 12.8276L19 13.5776H19L19 12.8276ZM18.4865 11.7609C18.0686 11.4542 17.6081 11.0712 17.2595 10.6681C16.8912 10.2423 16.75 9.91131 16.75 9.69673H15.25C15.25 10.4666 15.6912 11.1479 16.1249 11.6493C16.5782 12.1735 17.1391 12.6327 17.5992 12.9703L18.4865 11.7609ZM16.75 9.69673C16.75 9.12068 17.0126 8.87002 17.2419 8.78964C17.4922 8.70189 17.9558 8.72986 18.4813 9.23307L19.5187 8.14963C18.6943 7.36028 17.6579 7.05432 16.7457 7.3741C15.8125 7.70123 15.25 8.59955 15.25 9.69673H16.75ZM20.4008 12.9703C20.8609 12.6327 21.4218 12.1735 21.8751 11.6493C22.3088 11.1479 22.75 10.4666 22.75 9.69672H21.25C21.25 9.91132 21.1088 10.2424 20.7405 10.6681C20.3919 11.0713 19.9314 11.4542 19.5135 11.7609L20.4008 12.9703ZM22.75 9.69672C22.75 8.59954 22.1875 7.70123 21.2543 7.37409C20.3421 7.05432 19.3057 7.36028 18.4813 8.14963L19.5187 9.23307C20.0442 8.72986 20.5078 8.70189 20.7581 8.78964C20.9874 8.87002 21.25 9.12068 21.25 9.69672H22.75ZM17.5992 12.9703C17.9678 13.2407 18.3816 13.5776 19 13.5776L19 12.0776C18.9756 12.0776 18.9605 12.0775 18.9061 12.0488C18.8202 12.0034 18.7128 11.9269 18.4865 11.7609L17.5992 12.9703ZM19.5135 11.7609C19.2872 11.9269 19.1798 12.0034 19.0939 12.0488C19.0395 12.0775 19.0244 12.0776 19 12.0776L19 13.5776C19.6184 13.5776 20.0322 13.2407 20.4008 12.9703L19.5135 11.7609Z" fill="#437576"></path>
                                    <path d="M17.9975 18C18 17.8358 18 17.669 18 17.5C18 15.0147 14.4183 13 10 13C5.58172 13 2 15.0147 2 17.5C2 19.9853 2 22 10 22C12.231 22 13.8398 21.8433 15 21.5634" stroke="#437576" stroke-width="1.5" stroke-linecap="round"></path>
                                </g>
                            </svg>
                        </span>
                    </h1>

                    <p>
                        <?= Yii::t('app', 'Login please...') ?>
                    </p>


                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="row my-3 justify-content-center">
                        <div class="col-lg-9 w-100">

                            <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'fieldConfig' => [
                                    'template' => "{label}\n{input}\n{error}",
                                    'labelOptions' => ['class' => 'col-lg-4 col-form-label mr-lg-3'],
                                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                                ],
                            ]); ?>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label(Yii::t('app', 'Form name')) ?>

                            <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Form password')) ?>

                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => "<div class='custom-control custom-checkbox my-4'>{input} {label}</div>\n<div class='col-lg-8'>{error}</div>",
                                'label' => Yii::t('app', 'Remember Me'),
                            ]) ?>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-lg-3">
                                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-lg me-2', 'name' => 'login-button']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>

                    <div class="row mt-4 text-center">
                        <p>
                            <?= Yii::t('app', 'Form or create') ?>
                            <?= Html::a(Yii::t('app', 'Link to signup'), ['site/signup']) ?>
                        </p>
                    </div>
                    <div class="row mt-4 text-center">
                        <p>
                            <?= Yii::t('app', 'Forgot password?') ?>
                            <?= Html::a(Yii::t('app', 'Login reset password'), ['site/request-password-reset']) ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>