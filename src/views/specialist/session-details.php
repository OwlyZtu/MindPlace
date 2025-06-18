<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\models\Schedule $session */
/** @var \app\models\User $doctor */
/** @var \app\models\User $user */
/** @var array $therapyTypes */
/** @var array $themes */
/** @var array $approachTypes */

$this->title = 'Деталі консультації';
$this->params['breadcrumbs'][] = ['label' => 'Мої сесії', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

            <div class="card">
                <div class="card-body">
                    <p>
                        <strong>Код запису №<?= Html::encode($session->id) ?></strong>
                        <span class="float-end">
                            <?php ($session->isBooked()) ? $booked = 'disabled' : $booked = '' ?>
                            <?= Html::a('Видалити', ['cancel-schedule', 'id' => $session->id], ['class' => 'btn btn-danger btn-sm' . $booked]) ?>
                        </span>

                    </p>

                    <p>
                        <strong>Лікар:</strong>
                        <?= Html::encode(implode(', ', $doctor->getOptionLabels('specialization', 'specialization'))) ?> —
                        <?= Html::a(Html::encode($doctor->name), ['/specialist/' . $doctor->id], ['class' => 'link']) ?>
                    </p>

                    <p>
                        <strong>Клієнт:</strong>
                        <?= Html::encode($user->name ?? '—') ?>
                    </p>

                    <p>
                        <strong>Дата й час:</strong>
                        <?= Yii::$app->formatter->asDatetime($session->datetime, 'php:l, d M Y, H:i') ?> –
                        <?= Yii::$app->formatter->asTime($session->getEndTime(), 'short') ?>
                    </p>

                    <p>
                        <strong>Тривалість:</strong>
                        <?= Html::encode($session->duration) ?> хв
                    </p>

                    <p>
                        <strong>Статус:</strong>
                        <?php if ($session->status === $session::STATUS_BOOKED): ?>
                            <span class="badge bg-success text-bg-success">Записано</span>
                            <?php if ($session->meet_url): ?>
                    <p>
                        <strong>Сесія відбудеться за посиланням:</strong>
                        <a href="<?= Html::encode($session->meet_url) ?>" target="_blank">
                            <?= Html::encode($session->meet_url) ?>
                        </a>
                    </p>
                <?php else: ?>
                    <p class="text-danger">
                        Лікар ще не створив посилання на Google Meet.
                        Воно зʼявиться за 15 хвилин до початку сесії.
                    </p>
                <?php endif; ?>
            <?php elseif ($session->status === $session::STATUS_COMPLETED): ?>
                <span class="badge bg-primary">Завершено</span>
                <div class="mt-3 alert alert-info">
                    <p><strong>Рекомендації лікаря:</strong></p>
                    <p><?= Html::encode($session->details['recommendations'] ?? '—') ?></p>
                </div>
            <?php elseif ($session->status === $session::STATUS_CANCELED): ?>
                <span class="badge bg-danger">Скасовано</span>
            <?php else: ?>
                <span class="badge bg-secondary">Готово до запису</span>
            <?php endif; ?>
            </p>
                </div>
            </div>

            <hr class="my-4 border border-success border-2 opacity-75">

            <div class="card">
                <div class="card-body">
                    <h2>Запит клієнта</h2>

                    <div>
                        <p><strong>Тип терапії:</strong></p>
                        <?php if (!empty($therapyTypes)): ?>
                            <ul>
                                <?php foreach ($therapyTypes as $type): ?>
                                    <li><?= Html::encode($type) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>—</p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <p><strong>Тема:</strong></p>
                        <?php if (!empty($themes)): ?>
                            <ul>
                                <?php foreach ($themes as $theme): ?>
                                    <li><?= Html::encode($theme) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>—</p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <p><strong>Підхід:</strong></p>
                        <?php if (!empty($approachTypes)): ?>
                            <ul>
                                <?php foreach ($approachTypes as $approach): ?>
                                    <li><?= Html::encode($approach) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>—</p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <p><strong>Формат:</strong></p>
                        <p><?= Html::encode($session->format ?? '—') ?></p>
                    </div>

                    <div>
                        <p><strong>Коментар:</strong></p>
                        <p><?= $session->comment ?? '—' ?></p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <?= Html::a('Назад', ['site/profile'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
</div>
</div>