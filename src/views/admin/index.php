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
            <p class="lead">Ласкаво просимо до панелі адміністратора MindPlace.</p>
        </header>

        <!-- Системна інформація -->
        <div class="row my-5">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Статистика системи</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Загальна кількість користувачів
                                <span class="badge bg-success rounded-pill text-white">0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Верифіковані терапевти
                                <span class="badge bg-success rounded-pill text-white">0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Активні сесії
                                <span class="badge bg-success rounded-pill text-white">0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Нові реєстрації (сьогодні)
                                <span class="badge bg-success rounded-pill text-white">0</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Потребують уваги</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Нові заявки на верифікацію
                                <span class="badge bg-warning text-dark rounded-pill">0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Нові скарги
                                <span class="badge bg-warning text-dark rounded-pill">0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Повідомлення про помилки
                                <span class="badge bg-warning text-dark rounded-pill">0</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Управління -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Користувачі
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            Користувачі
                        </p>
                        <p class="card-text fs-6 text-muted">Управління користувачами системи, перегляд профілів та редагування інформації.</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a('Управління користувачами', ['/admin/users'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div> -->

            <!-- Терапевти -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            Терапевти
                        </p>
                        <p class="card-text fs-6 text-muted">Управління профілями терапевтів, верифікація та модерація.</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a('Управління терапевтами', ['/admin/users'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Звіти -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            Звіти
                        </p>
                        <p class="card-text fs-6 text-muted">Перегляд звітів про активність користувачів та статистика використання платформи.</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a('Перегляд звітів', ['/admin/reports'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Блог -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            Блог
                        </p>
                        <p class="card-text fs-6 text-muted">Управління статтями блогу, створення, редагування та видалення публікацій.</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a('Управління блогом', ['/admin/article-review'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Налаштування -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            Налаштування
                        </p>
                        <p class="card-text fs-6 text-muted">Загальні налаштування системи, параметри та конфігурація.</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a('Налаштування системи', ['/admin/settings'], ['class' => 'btn btn-primary py-2']) ?>
                    </div>
                </div>
            </div>

            <!-- Скарги та повідомлення -->
            <div class="col">
                <div class="card h-100 shadow-sm p-1 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body pb-0">
                        <p class="card-title fw-bold">
                            Скарги
                        </p>
                        <p class="card-text fs-6 text-muted">Перегляд та обробка скарг від користувачів, модерація контенту.</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 align-self-center">
                        <?= Html::a('Управління скаргами', ['/admin/complaints'], ['class' => 'btn btn-primary py-2']) ?>
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

    .card-text{
        background-color: rgb(145, 148, 77, 0.3);
        padding: 10px;
        border-radius: 15px;
    }
</style>