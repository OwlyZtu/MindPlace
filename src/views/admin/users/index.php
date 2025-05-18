<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\User[] $doctors */

use yii\bootstrap5\Html;
use app\models\User;
use yii\widgets\LinkPager;
use yii\data\Pagination;

$this->title = 'User panel';
$jsonFilePath = Yii::getAlias('@app/data/test_doctors.json');
$allDoctors = [];

if (file_exists($jsonFilePath)) {
    $doctorsData = json_decode(file_get_contents($jsonFilePath), true);
    foreach ($doctorsData as $doctorData) {
        $doctor = new User();
        foreach ($doctorData as $attribute => $value) {
            $doctor->$attribute = $value;
        }
        $allDoctors[] = $doctor;
    }
}

// Налаштування пагінації
$pageSize = 5; // Кількість елементів на сторінці
$totalCount = count($allDoctors);
$pagination = new Pagination([
    'totalCount' => $totalCount,
    'pageSize' => $pageSize,
    'defaultPageSize' => $pageSize,
]);

// Отримання даних для поточної сторінки
$offset = $pagination->offset;
$limit = $pagination->limit;
$doctors = array_slice($allDoctors, $offset, $limit);
?>
<div class="site-specialists">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="gradient-text-alt mt-4">
            <div class="specialists-header text-center">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="d-flex align-items-start">
                    <div class="nav-tabs flex-column  me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="btn active" id="v-pills-home-new" data-bs-toggle="pill" data-bs-target="#v-pills-new" type="button" role="tab" aria-controls="v-pills-new" aria-selected="true">
                            Нові заявки
                        </button>
                        <button class="btn" id="v-pills-profile-pending" data-bs-toggle="pill" data-bs-target="#v-pills-pending" type="button" role="tab" aria-controls="v-pills-pending" aria-selected="false">
                            В обробці
                        </button>
                        <button class="btn" id="v-pills-profile-rejected" data-bs-toggle="pill" data-bs-target="#v-pills-rejected" type="button" role="tab" aria-controls="v-pills-rejected" aria-selected="false">
                            Відхилено
                        </button>
                        <button class="btn" id="v-pills-profile-accepted" data-bs-toggle="pill" data-bs-target="#v-pills-accepted" type="button" role="tab" aria-controls="v-pills-accepted" aria-selected="false">
                            Прийнято
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class=" row" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                        <?php if (empty($doctors)): ?>
                            <div class="alert alert-info">
                                Немає заявок на розгляд
                            </div>
                        <?php else: ?>
                            <div class="list-group row row-gap-2">
                                <?php foreach ($doctors as $doctor): ?>
                                    <div class="list-group-item col-12">
                                        <div class="row m-1">
                                            <div class="col-md-10 my-auto">
                                                <h5 class="my-3">
                                                <?= Html::a(Html::encode($doctor->name), ['admin/users/view', 'id' => $doctor->id], ['class' => 'link-primary']) ?>
                                                </h5>
                                                <p class="mb-1 fs-6">Email: <?= Html::encode($doctor->email) ?></p>
                                                <p class="mb-1 fs-6">Спеціалізація: <?= Html::encode(implode(', ', $doctor->specialization)) ?></p>
                                            </div>
                                            <div class="col-md-2 text-center my-auto my-1">
                                                <?= Html::a('Прийняти', ['admin/users/approve', 'id' => $doctor->id], ['class' => 'btn btn-success btn-sm  mb-2']) ?>
                                                <?= Html::a('Відхилити', ['admin/users/reject', 'id' => $doctor->id], ['class' => 'btn btn-danger btn-sm  mb-2']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Віджет пагінації -->
                            <div class="pagination-container mt-4">
                                <?= LinkPager::widget([
                                    'pagination' => $pagination,
                                    'options' => ['class' => 'pagination justify-content-center'],
                                    'linkContainerOptions' => ['class' => 'page-item'],
                                    'linkOptions' => ['class' => 'page-link'],
                                    'disabledListItemSubTagOptions' => ['class' => 'page-link'],
                                ]); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" tabindex="0">
                        ...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>