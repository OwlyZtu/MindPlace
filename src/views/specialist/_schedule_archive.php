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

                            <?php if (!$item->isBooked()): ?>
                                <?= Html::a(Yii::t('schedules', 'Cancel'), ['cancel-schedule', 'id' => $item->id], ['class' => 'btn btn-danger btn-sm']) ?>

                            <?php endif; ?>
                    </span>
                    <strong><?= Yii::t('schedules', 'Date') ?>:</strong> <?= Yii::$app->formatter->asDatetime($item->datetime, ' d/m/Y H:i ') ?><br>
                    <strong><?= Yii::t('schedules', 'Duration') ?>:</strong> <?= $item->duration ?> <?= Yii::t('schedules', 'minutes') ?><br>
                    <strong><?= Yii::t('schedules', 'Session') ?>:</strong>
                    <?php if ($item->isBooked()): ?>
                        <?= Yii::t('schedules', 'Booked') ?> (ID: <?= $item->client_id ?>)
                    <?php else: ?>
                        <?= Yii::t('schedules', 'Free') ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-warning mt-2 text-center">
            <p>
                <?= Yii::t('schedules', 'No sessions') ?>
            </p>
        </div>
    <?php endif; ?>
</div>