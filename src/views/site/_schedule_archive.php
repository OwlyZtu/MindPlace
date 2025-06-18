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
        <ul class="list-group mb-4">
            <?php foreach ($archiveSchedules as $item): ?>
                <li class="list-group-item">
                    <span class="float-end">
                        <?= Html::a('Деталі', ['session-details', 'id' => $item->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    </span>
                    <strong>Дата:</strong> <?= Yii::$app->formatter->asDatetime($item->datetime, ' d/m/Y H:i ') ?><br>
                    <strong>Тривалість:</strong> <?= $item->duration ?> хв.<br>
                    <?php if ($item->status === $item::STATUS_CANCELED): ?>
                        <p class="text-danger">
                            Ви відмінили запис.
                        </p>
                    <?php elseif ($item->status === $item::STATUS_COMPLETED): ?>
                        <p class="text-success">
                            Сесія пройшла успішно. Перегляньте рекомендації лікаря
                        </p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-warning mt-2 text-center">
            <p>
                Сесій ще не проводилося
            </p>
        </div>
    <?php endif; ?>
</div>