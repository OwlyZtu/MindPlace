<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var  \yii\bootstrap5\ActiveFormAsset::register($this); */

/** @var app\models\forms\therapistJoin\TherapistDocumentsForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>
<fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
    <?php $form = ActiveForm::begin([
        'id' => 'form-documents',
        'action' => ['site/save-documents'],
        'options' => ['enctype' => 'multipart/form-data'],
        'method' => 'post'
    ]); ?>

    <legend><?= Yii::t('therapist-join-page', 'Documents') ?></legend>

    <?= $form->field($model, 'education_file')->fileInput()->hint(Yii::t('therapist-join-page', 'file hint')) ?>

    <?= $form->field($model, 'additional_certification_file')->fileInput()->hint(Yii::t('therapist-join-page', 'file hint')) ?>

    <?= $form->field($model, 'photo')->fileInput()->hint(Yii::t('therapist-join-page', 'photo hint'))?>

    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</fieldset>