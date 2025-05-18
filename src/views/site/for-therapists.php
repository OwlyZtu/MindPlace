<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\TherapistJoinForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'FT title');
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'For therapists in MindPlace';
$this->params['meta_keywords'] = 'MindPlace, psychologists, information, therapy, specialists';

?>
<div class="site-for-therapists">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">

        <!-- #region Intro-->
        <div class=" gradient-text-alt mt-4">
            <div class="for-therapists-header text-center">
                <h1>
                    <?= Yii::t('app', 'FT intro h1') ?>
                </h1>
                <h2>
                    <?= Yii::t('app', 'FT intro h2') ?>
                </h2>
                <p>
                    <?= Yii::t('app', 'FT intro p1') ?>
                </p>
                <p>
                    <?= Yii::t('app', 'FT intro p2') ?>
                </p>
            </div>


            <!-- #region Benefits -->
            <div class="for-therapists-text text-center mb-3">
                <h3 class="mb-5">
                    <?= Yii::t('app', 'FT benefits title') ?>
                </h3>
                <div class="row justify-content-evenly mb-3">
                    <div class="col-lg-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-box"
                            viewBox="0 0 16 16">
                            <path
                                d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                        </svg>
                        <h4>
                            <?= Yii::t('app', 'FT benefits 1') ?>
                        </h4>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                            class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                            <path
                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                        </svg>
                        <h4>
                            <?= Yii::t('app', 'FT benefits 2') ?>
                        </h4>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                            class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5" />
                        </svg>
                        <h4>
                            <?= Yii::t('app', 'FT benefits 3') ?>
                        </h4>
                    </div>
                </div>
                <h4>
                    <?= Yii::t('app', 'FT benefits 4') ?>
                </h4>
            </div>
            <!-- #endregion -->
        </div>
        <!-- #endregion -->

        <div class="col-lg-6 shadow-lg p-3 my-5 bg-body-tertiary-cstm rounded-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center mt-2">
                    <h1>
                        <?= Yii::t('app', 'FT Join Form') ?>
                        <span>
                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M12 5.50063L11.4596 6.02073C11.463 6.02421 11.4664 6.02765 11.4698 6.03106L12 5.50063ZM8.96173 18.9109L8.49742 19.4999L8.96173 18.9109ZM15.0383 18.9109L14.574 18.3219L15.0383 18.9109ZM7.00061 16.4209C6.68078 16.1577 6.20813 16.2036 5.94491 16.5234C5.68169 16.8432 5.72758 17.3159 6.04741 17.5791L7.00061 16.4209ZM2.34199 13.4115C2.54074 13.7749 2.99647 13.9084 3.35988 13.7096C3.7233 13.5108 3.85677 13.0551 3.65801 12.6917L2.34199 13.4115ZM13.4698 8.03034C13.7627 8.32318 14.2376 8.32309 14.5304 8.03014C14.8233 7.7372 14.8232 7.26232 14.5302 6.96948L13.4698 8.03034ZM2.75 9.1371C2.75 6.98623 3.96537 5.18252 5.62436 4.42419C7.23607 3.68748 9.40166 3.88258 11.4596 6.02073L12.5404 4.98053C10.0985 2.44352 7.26409 2.02539 5.00076 3.05996C2.78471 4.07292 1.25 6.42503 1.25 9.1371H2.75ZM8.49742 19.4999C9.00965 19.9037 9.55955 20.3343 10.1168 20.6599C10.6739 20.9854 11.3096 21.25 12 21.25V19.75C11.6904 19.75 11.3261 19.6293 10.8736 19.3648C10.4213 19.1005 9.95208 18.7366 9.42605 18.3219L8.49742 19.4999ZM15.5026 19.4999C16.9292 18.3752 18.7528 17.0866 20.1833 15.4758C21.6395 13.8361 22.75 11.8026 22.75 9.1371H21.25C21.25 11.3345 20.3508 13.0282 19.0617 14.4798C17.7469 15.9603 16.0896 17.1271 14.574 18.3219L15.5026 19.4999ZM22.75 9.1371C22.75 6.42503 21.2153 4.07292 18.9992 3.05996C16.7359 2.02539 13.9015 2.44352 11.4596 4.98053L12.5404 6.02073C14.5983 3.88258 16.7639 3.68748 18.3756 4.42419C20.0346 5.18252 21.25 6.98623 21.25 9.1371H22.75ZM14.574 18.3219C14.0479 18.7366 13.5787 19.1005 13.1264 19.3648C12.6739 19.6293 12.3096 19.75 12 19.75V21.25C12.6904 21.25 13.3261 20.9854 13.8832 20.6599C14.4405 20.3343 14.9903 19.9037 15.5026 19.4999L14.574 18.3219ZM9.42605 18.3219C8.63014 17.6945 7.82129 17.0963 7.00061 16.4209L6.04741 17.5791C6.87768 18.2624 7.75472 18.9144 8.49742 19.4999L9.42605 18.3219ZM3.65801 12.6917C3.0968 11.6656 2.75 10.5033 2.75 9.1371H1.25C1.25 10.7746 1.66995 12.1827 2.34199 13.4115L3.65801 12.6917ZM11.4698 6.03106L13.4698 8.03034L14.5302 6.96948L12.5302 4.97021L11.4698 6.03106Z" fill="currentColor"></path>
                                </g>
                            </svg>
                        </span>
                    </h1>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="row my-3 justify-content-center">
                        <div class="col-lg-9 w-100">
                            <?php $form = ActiveForm::begin(['id' => 'therapist-join-form']); ?>

                            <fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
                                <legend><?= Yii::t('app', 'Personal Information') ?></legend>
                                <?= $form->field($model, 'name')->textInput()->label(Yii::t('app', 'Full name') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'email')->label(Yii::t('app', 'Email') . '<span class="text-danger">*</span>') ?>

                                <?= $form->field($model, 'contact_number')->label(Yii::t('app', 'Contact Number') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'date_of_birth')->textInput([
                                    'type' => 'date',
                                    'value' => '2000-01-01',
                                    'min' => '1970-01-01',
                                    'max' => date('Y-m-d', strtotime('-18 years')), // Мінімальний вік 18 років
                                ])->label(Yii::t('app', 'Date of Birth') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'gender')->radioList([
                                    'male' => Yii::t('app', 'Male'),
                                    'female' => Yii::t('app', 'Female'),
                                ])->label(Yii::t('app', 'Gender') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'social_media')->textarea(['rows' => 3, 'placeholder' => 'e.g. Facebook, Instagram'])->label(Yii::t('app', 'Social Media')) ?>

                            </fieldset>

                            <fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
                                <legend><?= Yii::t('app', 'Therapy Specific') ?></legend>

                                <?= $form->field($model, 'language')->checkboxList([
                                    'uk' => Yii::t('app', 'Українська'),
                                    'en' => Yii::t('app', 'English'),
                                ])->label(Yii::t('app', 'Language') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'therapy_types')->checkboxList([
                                    'individual' => Yii::t('app', 'Therapy Types 1'),
                                    'group' => Yii::t('app', 'Therapy Types 2'),
                                ])->label(Yii::t('app', 'Type') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'theme')->checkboxList([
                                    'anxiety' => Yii::t('app', 'Themes 1'),
                                    'depression' => Yii::t('app', 'Themes 2'),
                                    'stress' => Yii::t('app', 'Themes 3'),
                                    'relationship' => Yii::t('app', 'Themes 4'),
                                    'self-esteem' => Yii::t('app', 'Themes 5'),
                                    'trauma' => Yii::t('app', 'Themes 6'),
                                ])->label(Yii::t('app', 'Themes') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'format')->checkboxList([
                                    'online' => 'Online',
                                    'offline' => 'Offline',
                                ])->label(Yii::t('app', 'Format') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'lgbt')->checkbox(['label' => Yii::t('app', 'LGBTQ+ friendly')]) ?>

                                <?= $form->field($model, 'military')->checkbox(['label' => Yii::t('app', 'Work with military personnel')]) ?>

                            </fieldset>

                            <fieldset class="border p-3 mb-3 shadow-lg p-3 mb-5 bg-body-tertiary-cstm rounded-5">
                                <legend><?= Yii::t('app', 'Education and Experience') ?></legend>
                                <?= $form->field($model, 'education_name')->textInput(['placeholder' => 'e.g. University Name'])->label(Yii::t('app', 'Education Name') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'education_file')->fileInput()->label(Yii::t('app', 'Education File') . '<span class="text-danger"> *</span>') ?>

                                <?= $form->field($model, 'additional_certification')->textInput(['placeholder' => 'e.g. Certification Name'])->label(Yii::t('app', 'Additional Certification')) ?>

                                <?= $form->field($model, 'additional_certification_file')->fileInput()->label(Yii::t('app', 'Additional Certification File')) ?>

                                <?= $form->field($model, 'experience')->textarea(['rows' => 6, 'placeholder' => 'e.g. Place: 5 years'])->label(Yii::t('app', 'Experience') . '<span class="text-danger"> *</span>') ?>

                            </fieldset>

                            <?= $form->field($model, 'privacy_policy')->checkbox()->label(Yii::t('app', 'I agree to the privacy policy') . '<span class="text-danger"> *</span>') ?>

                            <div class="form-group text-center">
                                <?= Html::submitButton(Yii::t('app', 'One moment'), ['class' => 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .for-therapists-form fieldset {
        border: 5px solidrgba(80, 114, 99, 0.69);
        border-radius: 20px;
        background-color: rgba(80, 114, 99, 0.35);
    }

    .for-therapists-form legend {
        font-weight: bold;
        padding: 0 10px;
        color: rgb(50, 77, 65);
    }
</style>