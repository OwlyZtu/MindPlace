<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\forms\FormOptions;



/** @var yii\web\View $this */
/** @var \app\models\SessionBookingForm $model */
/** @var \app\models\Schedule $schedule */
/** @var \app\models\User $doctor */
/** @var \app\models\User $user */

$this->title = Yii::t('book-session', 'Book a session');
?>

<div class="container mt-4">
    <div class="row">
        <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="alert alert-warning">
                <p>
                    <?= Yii::t('book-session', 'Before confirming the appointment, please read the following information:') ?>
                </p>
                <p>
                    <?= Yii::t('book-session', 'After confirming the appointment, you will be able to check the details of the appointment in your cabinet.') ?>
                </p>
                <p class="text-danger text-decoration-underline">
                    <?= Yii::t('book-session', 'If the session is held online, a link to Google Meet room with the doctor will appear in your account within an hour before the start of the consultation.') ?>
                </p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h5><?= Yii::t('book-session', 'Your data') ?></h5>
                    <p><strong><?= Yii::t('book-session', 'Name') ?>:</strong> <?= Html::encode($user->name) ?></p>
                    <p><strong><?= Yii::t('book-session', 'Email') ?>:</strong> <?= Html::encode($user->email) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h5><?= Yii::t('book-session', 'Specialist data') ?></h5>
                    <p><strong><?= Yii::t('book-session', 'Name') ?>:</strong> <?= Html::encode($doctor->name) ?></p>
                    <p><strong><?= Yii::t('book-session', 'Specialization') ?>:</strong> <?= Html::encode(implode(', ', $doctor->getOptionLabels('specialization', 'specialization')) ?? 'Не вказано') ?></p>
                    <p><strong><?= Yii::t('book-session', 'Date and time') ?>:</strong> <?= Yii::$app->formatter->asDatetime($schedule->datetime, 'php:l, d M Y H:i') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5><?= Yii::t('book-session', 'Details of the appointment') ?></h5>
                    <?php $form = ActiveForm::begin(); ?>
                    <?php
                    $therapyTypes = FormOptions::getDoctorOptions($doctor->therapy_types, 'therapy_types');
                    $themes = FormOptions::getDoctorOptions($doctor->theme, 'theme');
                    $approachTypes = FormOptions::getDoctorOptions($doctor->approach_type, 'approach_type');
                    $format = FormOptions::getDoctorOptions($doctor->format, 'format');
                    ?>
                    <?= $form->field($model, 'therapy_types')
                        ->dropDownList($therapyTypes)
                        ->label(Yii::t('book-session', 'Type') . '<span class="text-danger"> *</span>') ?>

                    <?= $form->field($model, 'format')
                        ->dropDownList($format)
                        ->label(Yii::t('book-session', 'Format') . '<span class="text-danger"> *</span>') ?>

                    <?= $form->field($model, 'theme')
                        ->checkboxList($themes)
                        ->label(Yii::t('book-session', 'Themes')) ?>

                    <?= $form->field($model, 'approach_type')
                        ->dropDownList($approachTypes)
                        ->label(Yii::t('book-session', 'Approach')) ?>


                    <?= $form->field($model, 'comment')
                        ->textarea(['id' => 'session-booking-form-comment', 'placeholder' => 'Додатковий коментар (необов’язково)']) ?>

                    <?= $form->field($model, 'add_to_google_calendar')->checkbox([
                        'label' => Yii::t('book-session', 'Add event to my Google Calendar')
                    ]) ?>

                    <div class="form-group mt-3 d-flex justify-content-center">
                        <?= Html::submitButton(Yii::t('book-session', 'Confirm appointment'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea#session-booking-form-comment',
        menubar: false,
        plugins: 'link lists code',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link'
    });
</script>