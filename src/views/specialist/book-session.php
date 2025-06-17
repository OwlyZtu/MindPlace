<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\forms\FormOptions;



/** @var yii\web\View $this */
/** @var \app\models\SessionBookingForm $model */
/** @var \app\models\Schedule $schedule */
/** @var \app\models\User $doctor */
/** @var \app\models\User $user */

$this->title = 'Запис на консультацію';
?>

<div class="container mt-4">
    <div class="row">
        <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="alert alert-warning">
                <p>
                    Для того, щоб записатись на консультацію, будь ласка, заповніть форму нижче.
                </p>
                <p>
                    Після підтвердження запису, у вашому кабінеті ви зможете перевірити деталі запису.
                </p>
                <p>
                    За
                    <span class="text-danger text-decoration-underline">
                        15 хвилин
                    </span>
                    до початку консультації у вашому кабінеті з'явиться посилання для входу в
                    <span class="text-danger text-decoration-underline">
                        GoogleMeet кімнату з лікарем.
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Ваші дані</h5>
                    <p><strong>Ім’я:</strong> <?= Html::encode($user->name) ?></p>
                    <p><strong>Email:</strong> <?= Html::encode($user->email) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Дані спеціаліста</h5>
                    <p><strong>Ім’я:</strong> <?= Html::encode($doctor->name) ?></p>
                    <p><strong>Спеціальність:</strong> <?= Html::encode(implode(', ', $doctor->getOptionLabels('specialization', 'specialization')) ?? 'Не вказано') ?></p>
                    <p><strong>Дата та час:</strong> <?= Yii::$app->formatter->asDatetime($schedule->datetime, 'php:l, d M Y H:i') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5>Деталі запису</h5>
                    <?php $form = ActiveForm::begin(); ?>
                    <?php
                    $therapyTypes = FormOptions::getDoctorOptions($doctor->therapy_types, 'therapy_types');
                    $themes = FormOptions::getDoctorOptions($doctor->theme, 'theme');
                    $approachTypes = FormOptions::getDoctorOptions($doctor->approach_type, 'approach_type');
                    $format = FormOptions::getDoctorOptions($doctor->format, 'format');
                    ?>
                    <?= $form->field($model, 'therapy_types')
                        ->dropDownList($therapyTypes, ['prompt' => 'Оберіть напрям терапії'])
                        ->label(Yii::t('therapist-join-page', 'Type') . '<span class="text-danger"> *</span>') ?>

                    <?= $form->field($model, 'format')
                        ->dropDownList($format, ['prompt' => 'Оберіть формат консультації'])
                        ->label(Yii::t('therapist-join-page', 'Format') . '<span class="text-danger"> *</span>') ?>

                    <?= $form->field($model, 'theme')
                        ->checkboxList($themes)
                        ->label(Yii::t('therapist-join-page', 'Themes')) ?>

                    <?= $form->field($model, 'approach_type')
                        ->dropDownList($approachTypes, ['prompt' => 'Оберіть підхід (необов’язково)'])
                        ->label(Yii::t('therapist-join-page', 'Approach')) ?>


                    <?= $form->field($model, 'comment')
                        ->textarea(['id' => 'session-booking-form-comment', 'placeholder' => 'Додатковий коментар (необов’язково)']) ?>

                    <?= $form->field($model, 'add_to_google_calendar')->checkbox([
                        'label' => 'Додати подію в мій Google Calendar'
                    ]) ?>

                    <div class="form-group mt-3 d-flex justify-content-center">
                        <?= Html::submitButton('Підтвердити запис', ['class' => 'btn btn-primary']) ?>
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