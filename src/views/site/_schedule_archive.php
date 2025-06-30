<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $archiveSchedulesProvider */

use yii\widgets\LinkPager;
use yii\helpers\Html;

$archiveSchedules = $archiveSchedulesProvider->getModels();
$pagination = $archiveSchedulesProvider->getPagination();
?>

<div>
    <?php if (!empty($archiveSchedules)): ?>
        <ul class="list-group m-4">
            <?php foreach ($archiveSchedules as $item): ?>
                <li class="list-group-item">
                    <span class="float-end">
                        <?= Html::a(Yii::t('schedules', 'Details'), ['session-details', 'id' => $item->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    </span>
                    <strong><?= Yii::t('schedules', 'Date') ?>:</strong> <?= Yii::$app->formatter->asDatetime($item->datetime, 'php:d.m.Y H:i') ?><br>
                    <strong><?= Yii::t('schedules', 'Duration') ?>:</strong> <?= $item->duration ?> хв.<br>
                    <?php if ($item->status === $item::STATUS_CANCELED): ?>
                        <p class="text-danger">
                            <?= Yii::t('schedules', 'You cancelled') ?>
                        </p>
                    <?php elseif ($item->status === $item::STATUS_COMPLETED): ?>
                        <p class="text-success">
                            <?= Yii::t('schedules', 'Session completed') ?>
                        </p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'activePageCssClass' => 'page-item active',
            'disabledPageCssClass' => 'page-item disabled',
        ]); ?>
    <?php else: ?>
        <div class="alert alert-warning mt-2 text-center">
            <p>
                <?= Yii::t('schedules', 'No future sessions') ?>
            </p>
        </div>
    <?php endif; ?>
</div>