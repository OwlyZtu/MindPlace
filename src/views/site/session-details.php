<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\models\Schedule $session */
/** @var \app\models\User $doctor */
/** @var \app\models\User $user */
/** @var array $therapyTypes */
/** @var array $themes */
/** @var array $approachTypes */

$this->title = Yii::t('specialist', 'Details of the consultation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('specialist', 'My sessions'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

            <div class="card">
                <div class="card-body">
                    <p>
                        <strong>№<?= Html::encode($session->id) ?></strong>
                        <?php if ($session->isBooked() && !$session::STATUS_CANCELED): ?>
                            <?= Html::a(Yii::t('specialist', 'Cancel'), ['site/session-cancel', 'id' => $session->id], ['class' => 'btn btn-danger btn-sm float-end']) ?>
                        <?php endif; ?>
                    </p>

                    <p>
                        <strong><?= Yii::t('specialist', 'Specialist') ?>:</strong>
                        <?= Html::encode(implode(', ', $doctor->getOptionLabels('specialization', 'specialization'))) ?> —
                        <?= Html::a(Html::encode($doctor->name), ['/specialist/' . $doctor->id], ['class' => 'link']) ?>
                    </p>

                    <p>
                        <strong><?= Yii::t('specialist', 'Client') ?>:</strong>
                        <?= Html::encode($user->name ?? '—') ?>
                    </p>

                    <p>
                        <strong><?= Yii::t('specialist', 'Date and time') ?>:</strong>
                        <?= Yii::$app->formatter->asDatetime($session->datetime, 'php:l, d M Y, H:i') ?> –
                        <?= Yii::$app->formatter->asTime($session->getEndTime(), 'short') ?>
                    </p>

                    <p>
                        <strong><?= Yii::t('specialist', 'Duration') ?>:</strong>
                        <?= Html::encode($session->duration) ?> <?= Yii::t('specialist', 'min') ?>
                    </p>

                    <p>
                        <strong><?= Yii::t('specialist', 'Status') ?>:</strong>
                        <?php if ($session->status === $session::STATUS_BOOKED): ?>
                            <span class="badge bg-success"><?= Yii::t('specialist', 'Booked') ?></span>
                            <?php if ($session->meet_url): ?>
                    <p><strong><?= Yii::t('specialist', 'Link to the meeting') ?>:</strong>
                        <a href="<?= Html::encode($session->meet_url) ?>" target="_blank">
                            <?= Html::encode($session->meet_url) ?>
                        </a>
                    </p>
                <?php else: ?>
                    <p class="text-danger">
                        <?= Yii::t('specialist', 'Link to the meeting will be available 15 minutes before the session starts.') ?>
                    </p>
                <?php endif; ?>
            <?php elseif ($session->status === $session::STATUS_COMPLETED): ?>
                <span class="badge bg-primary"><?= Yii::t('specialist', 'Completed') ?></span>
                <div class="mt-3 alert alert-info">
                    <p><strong><?= Yii::t('specialist', 'Recommendations from the doctor') ?>:</strong></p>
                    <p><?= Html::encode($session->details['recommendations'] ?? '—') ?></p>
                </div>
            <?php elseif ($session->status === $session::STATUS_CANCELED): ?>
                <span class="badge bg-danger"><?= Yii::t('specialist', 'Canceled') ?></span>
            <?php else: ?>
                <span class="badge bg-secondary"><?= Yii::t('specialist', 'Unknown') ?></span>
            <?php endif; ?>
            </p>
                </div>
            </div>

            <hr class="my-4 border border-success border-2 opacity-75">

            <div class="card">
                <div class="card-body">
                    <h2><?= Yii::t('specialist', 'Details of the consultation') ?></h2>

                    <div>
                        <p><strong><?= Yii::t('specialist', 'Type of therapy') ?>:</strong></p>
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
                        <p><strong><?= Yii::t('specialist', 'Theme') ?>:</strong></p>
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
                        <p><strong><?= Yii::t('specialist', 'Approach') ?>:</strong></p>

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
                        <p><strong><?= Yii::t('specialist', 'Format') ?>:</strong></p>
                        <p><?= Html::encode($session->format ?? '—') ?></p>
                    </div>

                    <div>
                        <p><strong><?= Yii::t('specialist', 'Comment') ?>:</strong></p>
                        <p><?= $session->comment ?? '—' ?></p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <?= Html::a(Yii::t('specialist', 'Back'), ['site/profile'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
</div>
</div>