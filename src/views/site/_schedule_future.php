<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $futureSchedulesProvider */
/** @var \app\models\Schedule $schedule_model */

$futureSchedules = $futureSchedulesProvider->getModels();
$pagination = $futureSchedulesProvider->getPagination();
?>

<div>
    <?php if (!empty($futureSchedules)): ?>
        <ul class="list-group m-4">
            <?php foreach ($futureSchedules as $item): ?>
                <li class="list-group-item my-1">
                    <span class="float-end">
                        <?= Html::a(Yii::t('schedules', 'Details'), ['session-details', 'id' => $item->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?php if ($item->status === $item::STATUS_BOOKED): ?>
                            <?= Html::a(Yii::t('schedules', 'Cancel'), ['site/session-cancel', 'id' => $item->id], ['class' => 'btn btn-danger btn-sm']) ?>
                        <?php endif; ?>
                    </span>
                    <p>
                        <strong>№<?= $item->id ?></strong>
                        <mark>
                            <?= Yii::$app->formatter->asDatetime($item->datetime, ' d/m/Y H:i ') ?>
                            - <?= $item->getEndTime() ?>
                            <span>
                                (<?= $item->duration ?> <?= Yii::t('schedules', 'minutes') ?>)
                            </span>
                        </mark>

                    </p>
                    <?php if ($item->meet_url && $item->status === $item::STATUS_BOOKED): ?>
                        <p>
                            <strong><?= Yii::t('schedules', 'Session link') ?>:</strong>
                            <a href="<?= $item->meet_url ?>" target="_blank">
                                <?= $item->meet_url ?>
                            </a>
                        </p>
                    <?php elseif (!$item->meet_url && $item->status === $item::STATUS_BOOKED): ?>
                        <p class="text-danger">
                            <?= Yii::t('schedules', 'No link') ?>
                        </p>
                    <?php elseif ($item->status === $item::STATUS_CANCELED): ?>
                        <p class="text-danger">
                            <?= Yii::t('schedules', 'You cancelled') ?>
                        </p>
                    <?php else: ?>
                        <p>
                            <strong><?= Yii::t('schedules', 'Session completed') ?></strong>
                        </p>
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

</div>