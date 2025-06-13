<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var  \yii\bootstrap5\ActiveFormAsset::register($this); */

/** @var app\models\forms\therapistJoin\TherapistApproachesForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\forms\FormOptions;

?>
<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
    <?php $form = ActiveForm::begin([
        'id' => 'form-approaches',
        'action' => ['site/save-approaches'],
        'enableAjaxValidation' => true
    ]); ?>

    <legend><?= Yii::t('therapist-join-page', 'Therapy Specific') ?></legend>

    <?= $form->field($model, 'language')->checkboxList(
        FormOptions::getLanguageOptions()
    )->label(Yii::t('therapist-join-page', 'Language') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'therapy_types')->checkboxList(
        FormOptions::getTherapyTypesOptions()
    )->label(Yii::t('therapist-join-page', 'Type') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'approach_type')->checkboxList(
        FormOptions::getApproachTypeOptions()
    )->label(Yii::t('therapist-join-page', 'Approach') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'theme')->checkboxList(
        FormOptions::getThemeOptions()
    )->label(Yii::t('therapist-join-page', 'Themes') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'format')->checkboxList(
        FormOptions::getFormatOptions()
    )->label(Yii::t('therapist-join-page', 'Format') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'lgbt')->checkbox()->label(Yii::t('therapist-join-page', 'LGBTQ+ friendly')) ?>

    <?= $form->field($model, 'military')->checkbox()->label(Yii::t('therapist-join-page', 'Work with military personnel')) ?>
    
    <?= Html::submitButton('Зберегти') ?>
    <?php ActiveForm::end(); ?>
</fieldset>