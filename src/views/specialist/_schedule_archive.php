<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $archiveSchedulesProvider */
use yii\widgets\LinkPager;
$archiveSchedules = $archiveSchedulesProvider->getModels();
$pagination = $archiveSchedulesProvider->getPagination();
?>

<div>
    <?php if (!empty($archiveSchedules)): ?>
        <ul class="list-group mb-4">
            <?php foreach ($archiveSchedules as $item): ?>
                <li class="list-group-item">
                    <strong>Дата:</strong> <?= Yii::$app->formatter->asDatetime($item->datetime, ' d/m/Y H:i ') ?><br>
                    <strong>Тривалість:</strong> <?= $item->duration ?> хв.<br>
                    <strong>Сеанс:</strong>
                    <?php if ($item->session): ?>
                        Призначено (ID: <?= $item->session->id ?>)
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