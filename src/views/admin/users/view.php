<?php

/** @var yii\web\View $this */
/** @var app\models\User $doctor */

use yii\bootstrap5\Html;
use yii\widgets\DetailView;

$this->title = 'Перегляд профілю: ' . $doctor->name;
$this->params['breadcrumbs'][] = ['label' => 'Управління користувачами', 'url' => ['/admin/users']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="gradient-text-alt mt-4">
            <div class="specialists-header text-center">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm p-3 mb-4 bg-body-tertiary-cstm rounded-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h2><?= Html::encode($doctor->name) ?></h2>
                                <p class="text-muted"><?= Html::encode(implode(', ', $doctor->specialization)) ?></p>
                            </div>
                            <div class="col-md-4 text-end">
                                <?= Html::a('Прийняти', ['approve', 'id' => $doctor->id], ['class' => 'btn btn-primary m-2']) ?>
                                <?= Html::a('Відхилити', ['reject', 'id' => $doctor->id], ['class' => 'btn btn-danger m-2']) ?>
                                <?= Html::a('Повернутися до списку', ['/admin/users'], ['class' => 'btn btn-secondary m-2']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h3>Основна інформація</h3>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Email:</th>
                                        <td><?= Html::encode($doctor->email) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Телефон:</th>
                                        <td><?= Html::encode($doctor->contact_number) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Дата народження:</th>
                                        <td><?= Html::encode($doctor->date_of_birth) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Місто:</th>
                                        <td><?= Html::encode($doctor->city) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Стать:</th>
                                        <td><?= Html::encode($doctor->gender) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Мови:</th>
                                        <td><?= Html::encode(implode(', ', $doctor->language)) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3>Професійна інформація</h3>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Спеціалізація:</th>
                                        <td><?= Html::encode(implode(', ', $doctor->specialization)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Типи терапії:</th>
                                        <td><?= Html::encode(implode(', ', $doctor->therapy_types)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Теми:</th>
                                        <td><?= Html::encode(implode(', ', $doctor->theme)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Підходи:</th>
                                        <td><?= Html::encode(implode(', ', $doctor->approach_type)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Формат:</th>
                                        <td><?= Html::encode(implode(', ', $doctor->format)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Робота з ЛГБТ:</th>
                                        <td><?= $doctor->lgbt ? 'Так' : 'Ні' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Робота з військовими:</th>
                                        <td><?= $doctor->military ? 'Так' : 'Ні' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h3>Освіта та сертифікати</h3>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Освіта:</th>
                                        <td><?= Html::encode($doctor->education_name) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Файл диплому:</th>
                                        <td>
                                            <?php if ($doctor->education_file): ?>
                                                <?= Html::a('Переглянути', ['download', 'file' => $doctor->education_file], ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?php else: ?>
                                                Не завантажено
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Додаткові сертифікати:</th>
                                        <td><?= Html::encode($doctor->additional_certification) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Файл сертифікату:</th>
                                        <td>
                                            <?php if ($doctor->additional_certification_file): ?>
                                                <?= Html::a('Переглянути', ['download', 'file' => $doctor->additional_certification_file], ['class' => 'btn btn-sm btn-primary']) ?>
                                            <?php else: ?>
                                                Не завантажено
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h3>Досвід та соціальні мережі</h3>
                                <h4>Досвід:</h4>
                                <ul>
                                    <?php foreach ($doctor->experience as $exp): ?>
                                        <li><?= Html::encode($exp) ?></li>
                                    <?php endforeach; ?>
                                </ul>

                                <h4>Соціальні мережі:</h4>
                                <ul>
                                    <?php foreach ($doctor->social_media as $platform => $link): ?>
                                        <li>
                                            <?= ucfirst(Html::encode($platform)) ?>: 
                                            <?= Html::a(Html::encode($link), $link, ['target' => '_blank']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>