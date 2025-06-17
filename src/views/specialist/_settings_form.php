<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\UserSettingsForm $model */
?>
<div>
    <div class="col-lg-10 mt-4">
        <h4>
            Особисті дані
        </h4>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'update-user-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-4 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>
    <div class="row mt-4">
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'name')->textInput(['value' => Yii::$app->user->identity->name])
                ->label(Yii::t('app', 'Form name')); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'email')->textInput(['value' => Yii::$app->user->identity->email])
                ->label(Yii::t('app', 'Form email')) ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'contact_number')->textInput(['placeholder' => Yii::$app->user->identity->contact_number])
                ->label(Yii::t('app', 'Form phone')) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'date_of_birth')->input('date', ['value' => Yii::$app->user->identity->date_of_birth])
                ->label(Yii::t('app', 'Date of birth')) ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-10">
            <h4>
                Зміна паролю
            </h4>
        </div>
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'password')->passwordInput()
                ->label(Yii::t('app', 'Form password')); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 're_password')->passwordInput()
                ->label(Yii::t('app', 'Form password repeat')) ?>
        </div>
    </div>
    <div class="form-group row justify-content-center">
        <div class="col-lg-6 text-center">
            <?= Html::submitButton(
                Yii::t('app', 'Profile settings button'),
                ['class' => 'btn btn-primary btn-lg me-2', 'name' => 'save-settings-button']
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
