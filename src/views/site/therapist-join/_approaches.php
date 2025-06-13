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

    <legend><?= Yii::t('app', 'Therapy Specific') ?></legend>

    <?= $form->field($model, 'language')->checkboxList(
        FormOptions::getLanguageOptions()
    )->label(Yii::t('app', 'Language') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'therapy_types')->checkboxList(
        FormOptions::getTherapyTypesOptions()
    )->label(Yii::t('app', 'Type') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'approach_type')->checkboxList(
        FormOptions::getApproachTypeOptions()
    )->label(Yii::t('app', 'approach_type') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'theme')->checkboxList(
        FormOptions::getThemeOptions()
    )->label(Yii::t('app', 'Themes') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'format')->checkboxList(
        FormOptions::getFormatOptions()
    )->label(Yii::t('app', 'Format') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'lgbt')->checkbox()->label(Yii::t('app', 'LGBTQ+ friendly')) ?>

    <?= $form->field($model, 'military')->checkbox()->label(Yii::t('app', 'Work with military personnel')) ?>
    
    <?= Html::submitButton('Зберегти') ?>
    <?php ActiveForm::end(); ?>
</fieldset>