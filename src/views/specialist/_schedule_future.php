<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $futureSchedulesProvider */
/** @var \app\models\Schedule $schedule_model */

$futureSchedules = $futureSchedulesProvider->getModels();
$pagination = $futureSchedulesProvider->getPagination();
$busyOnly = Yii::$app->request->get('busy_only', 1);
?>

<div>

    <?php
    $urlParams = Yii::$app->request->get();
    $toggleBusy = $busyOnly ? 0 : 1;
    $buttonLabel = $busyOnly ? Yii::t('schedules', 'Show all') : Yii::t('schedules', 'Show only booked');
    $urlParams['busy_only'] = $toggleBusy;
    ?>
    <div class="m-3">
        <p>
            <?= $busyOnly ? Yii::t('schedules', 'Busy slots') : Yii::t('schedules', 'Full schedule') ?>:
            <span class="float-end">
                <?= Html::a($buttonLabel, array_merge(['profile'], $urlParams), ['class' => 'btn btn-primary']) ?>

            </span>
        </p>
    </div>
    <?php if (!empty($futureSchedules)): ?>
        <ul class="list-group m-4">
            <?php foreach ($futureSchedules as $item): ?>
                <li class="list-group-item my-1">
                    <p>
                        <strong>№<?= $item->id ?></strong>
                        <mark>
                            <?= Yii::$app->formatter->asDatetime($item->datetime, ' d/m/Y H:i ') ?>
                        </mark>
                        <span class="float-end">
                            <?= Html::a(Yii::t('schedules', 'Details'), ['session-details', 'id' => $item->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?php if (!$item->isBooked()): ?>
                                <?= Html::a(Yii::t('schedules', 'Cancel'), ['cancel-schedule', 'id' => $item->id], ['class' => 'btn btn-danger btn-sm']) ?>
                            <?php endif; ?>
                        </span>
                    </p>
                    <p></p>
                    <strong><?= Yii::t('schedules', 'Duration') ?>:</strong> <?= $item->duration ?> <?= Yii::t('schedules', 'minutes') ?><br>
                    <strong><?= Yii::t('schedules', 'Session') ?>:</strong>
                    <?php if ($item->isBooked()): ?>
                        <?= Yii::t('schedules', 'Booked') ?> (ID: <?= $item->client_id ?>)
                        <?php if ($item->status == $item::STATUS_CANCELED): ?>
                            <span class="badge bg-danger">
                                <?= Yii::t('schedules', 'Canceled by client') ?>
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?= Yii::t('schedules', 'Free') ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?= Html::tag(
            'nav',
            LinkPager::widget([
                'pagination' => $pagination,
                'options' => ['class' => 'pagination justify-content-center mt-3'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => ' page-link disabled',
                'prevPageLabel' =>
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g><g id="SVGRepo_icurrentColoronCarrier"> <path d="M4 12L10 6M4 12L10 18M4 12H14.5M20 12H17.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path> </g></svg>',
                'nextPageLabel' =>
                '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g><g id="SVGRepo_icurrentColoronCarrier"> <path d="M4 12H6.5M20 12L14 6M20 12L14 18M20 12H9.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path> </g></svg>',
                'maxButtonCount' => 4,
            ]),
            ['aria-label' => 'Pagination']
        );
        ?>

    <?php else: ?>
        <div class="alert alert-warning mt-2 text-center">
            <p>
                <?= Yii::t('schedules', 'No future sessions') ?>
            </p>
        </div>
    <?php endif; ?>
    <div>
        <h4><?= Yii::t('schedules', 'Create schedule') ?>:</h4>

        <?php $form = ActiveForm::begin(['id' => 'create-schedule']); ?>
        <?= Html::hiddenInput('form_name', 'create-schedule') ?>
        <div class="d-none">
            <?= $form->field($schedule_model, 'doctor_id')->textInput(['value' => Yii::$app->user->identity->id]) ?>
        </div>

        <?= $form->field($schedule_model, 'datetime')->textInput(['type' => 'datetime-local', 'min' => date('Y-m-d\TH:i')])->label(Yii::t('schedules', 'Date')) ?>

        <?= $form->field($schedule_model, 'duration')->input('number', ['min' => 15, 'step' => 5, 'value' => 30])->label(Yii::t('schedules', 'Duration')) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('schedules', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>