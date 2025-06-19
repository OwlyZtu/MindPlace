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
                            <?php if (!$item->isBooked()): ?>
                                <?= Html::a('Видалити', ['cancel-schedule', 'id' => $item->id], ['class' => 'btn btn-danger btn-sm']) ?>
                            <?php endif; ?>
                    </span>
                    <strong>Дата:</strong> <?= Yii::$app->formatter->asDatetime($item->datetime, ' d/m/Y H:i ') ?><br>
                    <strong>Тривалість:</strong> <?= $item->duration ?> хв.<br>
                    <strong>Сеанс:</strong>
                    <?php if ($item->isBooked()): ?>
                        Призначено (ID: <?= $item->client_id ?>)
                    <?php else: ?>
                        Вільний
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