<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use app\models\forms\FormOptions;

$form = ActiveForm::begin([
    'id' => 'therapist-join-form',
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>

<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
    <legend><?= Yii::t('app', 'Personal Information') ?></legend>
    <?= $form->field($model, 'name')->textInput()->label(Yii::t('app', 'Full name') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'email')->label(Yii::t('app', 'Email') . '<span class="text-danger">*</span>') ?>

    <?= $form->field($model, 'contact_number')->label(Yii::t('app', 'Contact Number') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'date_of_birth')->textInput([
        'type' => 'date',
        'value' => '2000-01-01',
        'min' => '1970-01-01',
        'max' => date('Y-m-d', strtotime('-16 years')), // Мінімальний вік 16 років
    ])->label(Yii::t('app', 'Date of Birth') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'gender')->radioList(
        FormOptions::getGenderOptions()
    )->label(Yii::t('app', 'Gender') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'city')->dropDownList(
        FormOptions::getCityOptions(),
        ['promt' => 'Select city']
    ) ?>
    <?= $form->field($model, 'social_media')->textarea(['rows' => 3, 'placeholder' => 'e.g. Facebook, Instagram'])->label(Yii::t('app', 'Social Media')) ?>

</fieldset>

<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
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

    <?= $form->field($model, 'lgbt')->checkbox(['label' => Yii::t('app', 'LGBTQ+ friendly')]) ?>

    <?= $form->field($model, 'military')->checkbox(['label' => Yii::t('app', 'Work with military personnel')]) ?>

</fieldset>

<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
    <legend><?= Yii::t('app', 'Education and Experience') ?></legend>
    <?= $form->field($model, 'education_name')->textInput(['placeholder' => 'e.g. University Name'])->label(Yii::t('app', 'Education Name') . '<span class="text-danger"> *</span>') ?>

    <?= $form->field($model, 'education_file')->fileInput()->hint('Дозволені формати: PDF, DOC, DOCX. Максимальний розмір: 10MB') ?>

    <?= $form->field($model, 'additional_certification_file')->fileInput()->hint('Дозволені формати: PDF, DOC, DOCX. Максимальний розмір: 10MB') ?>

    <?= $form->field($model, 'experience')->textarea(['rows' => 6, 'placeholder' => 'e.g. Place: 5 years'])->label(Yii::t('app', 'Experience') . '<span class="text-danger"> *</span>') ?>

</fieldset>

<?= $form->field($model, 'privacy_policy')->checkbox()->label(Yii::t('app', 'I agree to the privacy policy') . '<span class="text-danger"> *</span>') ?>

<div class="form-group text-center mt-3">
    <?= Html::submitButton(Yii::t('app', 'One moment'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>