<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\therapistJoin\TherapistJoinForm $model */

use yii\helpers\Html;
use yii\helpers\Url;

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

        <?php if (Yii::$app->user->isGuest): ?>
            <div class="col-lg-6 text-center my-5">
                <h3><?= Yii::t('app', 'FT login first') ?></h3>
                <?= Html::a(Yii::t('app', 'Login'), ['/site/login'], ['class' => 'btn btn-primary btn-lg mt-3']) ?>
            </div>

        <?php else: ?>
            <?php if ($model->getApplicationStatus() === 'pending'): ?>
                <div class="col-lg-6 text-center my-5">
                    <h3><?= Yii::t('app', 'Your application is being reviewed') ?></h3>
                    <p><?= Yii::t('app', 'We will notify you once we review your application') ?></p>
                </div>

            <?php elseif ($model->getApplicationStatus() === 'rejected'): ?>
                <div class="col-lg-6 text-center my-5">
                    <h3><?= Yii::t('app', 'Your application has been rejected') ?></h3>
                    <p><?= Yii::t('app', 'Please contact us for more information') ?></p>
                </div>

            <?php elseif ($model->getApplicationStatus() === 'approved'): ?>
                <div class="col-lg-6 text-center my-5">
                    <h3><?= Yii::t('app', 'Your application has been approved') ?></h3>
                    <p><?= Yii::t('app', 'You can now start using MindPlace') ?></p>
                </div>
            <?php else: ?>
                <div class="col-lg-6 shadow-lg p-3 my-5 bg-body-tertiary-cstm rounded-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 text-center mt-2 gradient-text-alt">
                            <h1>
                                <?= Yii::t('app', 'FT Join Form') ?>
                                <span>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_icurrentColoronCarrier">
                                            <path d="M9 13.4L10.7143 15L15 11" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path>
                                            <path d="M21 16.0002C21 18.8286 21 20.2429 20.1213 21.1215C19.2426 22.0002 17.8284 22.0002 15 22.0002H9C6.17157 22.0002 4.75736 22.0002 3.87868 21.1215C3 20.2429 3 18.8286 3 16.0002V13.0002M16 4.00195C18.175 4.01406 19.3529 4.11051 20.1213 4.87889C21 5.75757 21 7.17179 21 10.0002V12.0002M8 4.00195C5.82497 4.01406 4.64706 4.11051 3.87868 4.87889C3.11032 5.64725 3.01385 6.82511 3.00174 9" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                            <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" stroke="currentColor" stroke-width="1.5"></path>
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
                                    <div id="therapist-join-form" data-form-url="<?= \yii\helpers\Url::to(['site/load-step']) ?>">
                                        <div class="steps">
                                            <div id="step-personal-info" class="step-tab" data-url="<?= Url::to(['site/load-step', 'step' => 'personal-info']) ?>"></div>
                                            <div id="step-approaches" class="step-tab" data-url="<?= Url::to(['site/load-step', 'step' => 'approaches']) ?>"></div>
                                            <div id="step-education" class="step-tab" data-url="<?= Url::to(['site/load-step', 'step' => 'education']) ?>"></div>
                                            <div id="step-documents" class="step-tab" data-url="<?= Url::to(['site/load-step', 'step' => 'documents']) ?>"></div>
                                        </div>
                                        <div id="step-container">
                                            <div class="d-flex justify-content-center align-items-center py-5">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Завантаження…</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php $this->registerJsFile('@web/js/therapist-join.js', ['depends' => [\yii\web\JqueryAsset::class]]); ?>
<style>
    .for-therapists-form fieldset {
        border: 5px solid rgba(80, 114, 99, 0.69);
        border-radius: 20px;
        background-color: rgba(80, 114, 99, 0.35);
    }

    .for-therapists-form legend {
        font-weight: bold;
        padding: 0 10px;
        color: rgb(50, 77, 65);
    }
</style>