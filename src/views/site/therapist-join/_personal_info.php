<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var  \yii\bootstrap5\ActiveFormAsset::register($this); */

/** @var app\models\forms\therapistJoin\TherapistPersonalInfonForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\forms\FormOptions;

?>
<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
    <?php $form = ActiveForm::begin([
        'id' => 'form-personal-info',
        'action' => ['site/save-personal-info'],
        'method' => 'post',
        'enableAjaxValidation' => true,
        'options' => [
            'data-pjax' => true
        ]
    ]); ?>

    <legend><?= Yii::t('therapist-join-page', 'Personal Information') ?></legend>
    <?= $form->field($model, 'name')->textInput([
        'value' => Yii::$app->user->identity->name,
    ])
        ->label(Yii::t('therapist-join-page', 'Full name') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'email')->textInput([
        'value' => Yii::$app->user->identity->email,
    ])
        ->label(Yii::t('therapist-join-page', 'Email') . '<span class="text-danger">*</span>') ?>

    <?= $form->field($model, 'contact_number')->textInput([
        'value' => Yii::$app->user->identity->contact_number,
    ])
        ->label(Yii::t('therapist-join-page', 'Contact Number') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'date_of_birth')->textInput([
        'type' => 'date',
        'value' => Yii::$app->user->identity->date_of_birth,
        'format' => 'dd-MM-yyyy'
    ])
        ->label(Yii::t('therapist-join-page', 'Date of Birth') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'gender')->radioList(
        FormOptions::getGenderOptions()
    )->label(Yii::t('therapist-join-page', 'Gender') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'city')->dropDownList(
        FormOptions::getCityOptions()
    )->label(Yii::t('therapist-join-page', 'City') . '<span class="text-danger"> *</span>') ?>
    <?= $form->field($model, 'social_media')->textarea(['id' => 'social_media', 'placeholder' => 'e.g. Facebook, Instagram'])->label(Yii::t('therapist-join-page', 'Social Media')) ?>

    <?= Html::submitButton(Yii::t('therapist-join-page', 'Save btn')) ?>
    <?php ActiveForm::end(); ?>
</fieldset>

<script>
    tinymce.init({
        selector: 'textarea#social_media',
        menubar: false,
        plugins: 'link lists code',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link'
    });
</script>