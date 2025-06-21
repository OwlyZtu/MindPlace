<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\Card;

$this->title = 'MindPlace Admin Panel';
?>

<div class="site-index">
    <div class="container py-4">
        <header class="pb-3 my-4 border-bottom">
            <h1 class="display-5 fw-bold"><?= Html::encode($this->title) ?></h1>
            <p class="lead"></p>
        </header>

        <!-- Системна інформація -->
        <div class="row my-5">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><?= Yii::t('admin', 'Index system info') ?></h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= Yii::t('admin', 'Index system info users') ?>
                                <span class="badge bg-success rounded-pill text-white">
                                    <?= app\models\User::find()->count() ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= Yii::t('admin', 'Index system info verified therapists') ?>
                                <span class="badge bg-success rounded-pill text-white">
                                    <?= app\models\User::find()->where(['role' => 'specialist'])->count() ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= Yii::t('admin', 'Index system info new registrations') ?>
                                <span class="badge bg-success rounded-pill text-white">
                                    <?= app\models\User::find()->where(['created_at' => date('Y-m-d')])->count() ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><?= Yii::t('admin', 'Index need attention') ?></h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= Yii::t('admin', 'Index new applications') ?>
                                <span class="badge bg-warning text-dark rounded-pill">
                                    <?= app\models\SpecialistApplication::find()->where(['status' => app\models\SpecialistApplication::STATUS_PENDING])->count() ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= Yii::t('admin', 'Index new messages') ?>
                                <span class="badge bg-warning text-dark rounded-pill">
                                    0
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= Yii::t('admin', 'Index error messages') ?>
                                <span class="badge bg-warning text-dark rounded-pill">
                                    0
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Управління -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Терапевти -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            <?= Yii::t('admin', 'Index therapists') ?>
                        </p>
                        <p class="card-text fs-6 text-muted"><?= Yii::t('admin', 'Card therapists descr') ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a(Yii::t('admin', 'Btn view'), ['/admin/users'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Звіти -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            <?= Yii::t('admin', 'Index summaries') ?>
                        </p>
                        <p class="card-text fs-6 text-muted"><?= Yii::t('admin', 'Card summaries descr') ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a(Yii::t('admin', 'Btn view'), ['/admin/reports'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Блог -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            <?= Yii::t('admin', 'Index blog') ?>
                        </p>
                        <p class="card-text fs-6 text-muted"><?= Yii::t('admin', 'Card blog descr') ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a(Yii::t('admin', 'Btn view'), ['/admin/article-review'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Скарги та повідомлення -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            <?= Yii::t('admin', 'Index messages') ?>
                        </p>
                        <p class="card-text fs-6 text-muted"><?= Yii::t('admin', 'Card messages descr') ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a(Yii::t('admin', 'Btn view'), ['/admin/complaints'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .card {
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-text {
        background-color: rgb(145, 148, 77, 0.3);
        padding: 10px;
        border-radius: 15px;
    }
</style>