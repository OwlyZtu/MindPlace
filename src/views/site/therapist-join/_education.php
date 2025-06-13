<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var \yii\bootstrap5\ActiveFormAsset::register($this); */
/** @var app\models\forms\therapistJoin\TherapistEducationForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\forms\FormOptions;
?>
<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
    <?php $form = ActiveForm::begin([
        'id' => 'form-education',
        'action' => ['site/save-education'],
        'enableAjaxValidation' => true
    ]); ?>

    <legend><?= Yii::t('therapist-join-page', 'Education and Experience') ?></legend>

    <?= $form->field($model, 'education_name')->textInput(['placeholder' => 'e.g. University Name'])->label(Yii::t('therapist-join-page', 'Education Name') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'specialization')->checkboxList(
        FormOptions::getSpecializationOptions()
    )->label(Yii::t('therapist-join-page', 'Specialization') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'additional_certification')->textInput(['placeholder' => 'e.g. Courses Name'])->label(Yii::t('therapist-join-page', 'Additional certification')) ?>

    <?= $form->field($model, 'experience')->textarea(['id' => 'experience', 'placeholder' => 'e.g. Place, position: 5 years'])
    ->label(Yii::t('therapist-join-page', 'Experience') . '<span class="text-danger"> *</span>') ?>

    <?= Html::submitButton('Зберегти') ?>
    <?php ActiveForm::end(); ?>
</fieldset>

<script>
  tinymce.init({
    selector: 'textarea#experience',
    menubar: false,
    plugins: 'link lists code',
    toolbar: 'undo redo | bold italic underline | bullist numlist | link'
  });
</script>