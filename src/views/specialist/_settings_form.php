<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\FormOptions;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\UserSettingsForm $profile_settings_model */
?>
<div>
    <div class="col-lg-10 mt-4">
        <h4>
            <?= Yii::t('profile', 'Personal data'); ?>
        </h4>
    </div>
    <?php

    $form = ActiveForm::begin([
        'id' => 'update-user-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-4 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]);
    $profile_settings_model->loadUserData(Yii::$app->user->identity); ?>
    <?= Html::hiddenInput('form_name', 'update-profile') ?>
    <div class="row mt-4">
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'name')->textInput()
                ->label(Yii::t('app', 'Form name')); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'email')->textInput()
                ->label(Yii::t('app', 'Form email')) ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'contact_number')->textInput()
                ->label(Yii::t('app', 'Form phone')) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'date_of_birth')->input('date',)
                ->label(Yii::t('app', 'Date of birth')) ?>
        </div>
    </div>
    <div class="row mt-4 justify-content-center">
        <!-- Фото профілю -->
        <div class="col-lg-6">
            <?= $form->field($profile_settings_model, 'photo')->fileInput()->label(Yii::t('app', 'Form photo')) ?>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-10">
            <h4>
                <?= Yii::t('profile', 'Change password'); ?>
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
    <?php if (Yii::$app->user->identity->isSpecialist()): ?>
        <div class="row mt-4">
            <div class="col-lg-10">
                <h4>
                    <?= Yii::t('profile', 'Profecional data'); ?>
                </h4>
            </div>

            <!-- Формат -->
            <div class="col-lg-6">
                <?= $form->field($profile_settings_model, 'format[]')->checkboxList(
                    FormOptions::getFormatOptions(),
                    [
                        'item' => function ($index, $label, $name, $checked, $value) use ($profile_settings_model) {
                            $disabled = in_array($value, $profile_settings_model->existing_format ?? []);
                            return Html::checkbox($name, $checked, [
                                'value' => $value,
                                'label' => $label,
                                'class' => 'form-check-input',
                            ]);
                        }
                    ]
                )->label(Yii::t('therapist-join-page', 'Format')) ?>
            </div>

            <!-- Тип терапії -->
            <div class="col-lg-6">
                <?= $form->field($profile_settings_model, 'therapy_types[]')->checkboxList(
                    FormOptions::getTherapyTypesOptions(),
                    [
                        'item' => function ($index, $label, $name, $checked, $value) use ($profile_settings_model) {
                            $disabled = in_array($value, $profile_settings_model->existing_therapy_types ?? []);
                            return Html::checkbox($name, $checked, [
                                'value' => $value,
                                'label' => $label,
                                'disabled' => $disabled,
                                'class' => 'form-check-input',
                            ]);
                        }
                    ]
                )->label(Yii::t('therapist-join-page', 'Therapy Specific')) ?>

            </div>

            <!-- Спеціалізація -->
            <div class="col-lg-6 mt-3">
                <?= $form->field($profile_settings_model, 'specialization[]')->checkboxList(
                    FormOptions::getSpecializationOptions(),
                    [
                        'item' => function ($index, $label, $name, $checked, $value) use ($profile_settings_model) {
                            $disabled = in_array($value, $profile_settings_model->existing_specialization ?? []);
                            return Html::checkbox($name, $checked, [
                                'value' => $value,
                                'label' => $label,
                                'disabled' => $disabled,
                                'class' => 'form-check-input',
                            ]);
                        }
                    ]
                )->label(Yii::t('therapist-join-page', 'Specialization')) ?>
            </div>

            <!-- Підходи -->
            <div class="col-lg-6 mt-3">
                <?= $form->field($profile_settings_model, 'approach_type[]')->checkboxList(
                    FormOptions::getApproachTypeOptions(),
                    [
                        'item' => function ($index, $label, $name, $checked, $value) use ($profile_settings_model) {
                            $disabled = in_array($value, $profile_settings_model->existing_approach_type ?? []);
                            return Html::checkbox($name, $checked, [
                                'value' => $value,
                                'label' => $label,
                                'disabled' => $disabled,
                                'class' => 'form-check-input',
                            ]);
                        }
                    ]
                )->label(Yii::t('therapist-join-page', 'Approach')) ?>
            </div>

            <!-- Досвід -->
            <div class="col-lg-12 mt-3">
                <?= $form->field($profile_settings_model, 'experience')->textarea([
                    'id' => 'profilesettingsform-experience',
                    'value' => $profile_settings_model->experience
                ])->label(Yii::t('profile', 'Profile experience')) ?>

            </div>

            <!-- Диплом (disabled) -->
            <div class="col-lg-6 mt-3">
                <?= Html::label(Yii::t('profile', 'No change'), null, ['class' => 'form-label']) ?>
                <?= Html::textInput(null, $profile_settings_model->education_file_url, [
                    'class' => 'form-control',
                    'disabled' => true,
                ]) ?>
                <?= Html::a(Yii::t('profile',Yii::t('profile', 'Profile download button')), $profile_settings_model->education_file_url, ['target' => '_blank', 'class' => 'btn btn-outline-primary mt-2']) ?>
            </div>

            <!-- Додаткові сертифікати -->
            <div class="col-lg-6 mt-3">
                <?= $form->field($profile_settings_model, 'additional_certification_file[]')
                    ->fileInput(['multiple' => true])
                    ->label(Yii::t('profile', 'Add Additional Certification')) ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group row justify-content-center">
        <div class="col-lg-6 text-center">
            <?= Html::submitButton(
                Yii::t('profile', 'Profile settings button'),
                ['class' => 'btn btn-primary btn-lg me-2', 'name' => 'save-settings-button']
            ) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    tinymce.init({
        selector: 'textarea#profilesettingsform-experience',
        menubar: false,
        plugins: 'link lists code',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link'
    });
</script>