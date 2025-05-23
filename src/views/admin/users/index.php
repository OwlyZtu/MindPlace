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
                        <button class="btn active" id="v-pills-user-new-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-new" type="button" role="tab" aria-controls="v-pills-user-new" aria-selected="true">
                            Нові заявки
                        </button>
                        <button class="btn" id="v-pills-user-pending-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-pending" type="button" role="tab" aria-controls="v-pills-user-pending" aria-selected="false">
                            В обробці
                        </button>
                        <button class="btn" id="v-pills-user-rejected-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-rejected" type="button" role="tab" aria-controls="v-pills-user-rejected" aria-selected="false">
                            Відхилено
                        </button>
                        <button class="btn" id="v-pills-user-accepted-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-accepted" type="button" role="tab" aria-controls="v-pills-user-accepted" aria-selected="false">
                            Прийнято
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active bg-transparent" id="v-pills-user-new" role="tabpanel" aria-labelledby="v-pills-user-new-tab" tabindex="0">
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
                                                <?= Html::a(Html::encode($doctor->name)
                                                . Html::tag(
                                                    'span',
                                                    '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                                                            </svg>',
                                                    ['class' => 'ms-1']
                                                )
                                                , ['admin/users/view', 'id' => $doctor->id], ['class' => 'link-primary']) ?>
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
                    <div class="tab-pane fade bg-transparent" id="v-pills-user-pending" role="tabpanel" aria-labelledby="v-pills-user-pending-tab" tabindex="0">
                        <div class="alert alert-info">
                            Немає заявок в обробці
                        </div>
                    </div>
                    <div class="tab-pane fade bg-transparent" id="v-pills-user-rejected" role="tabpanel" aria-labelledby="v-pills-user-rejected-tab" tabindex="0">
                        <div class="alert alert-info">
                            Немає відхилених заявок
                        </div>
                    </div>
                    <div class="tab-pane fade bg-transparent" id="v-pills-user-accepted" role="tabpanel" aria-labelledby="v-pills-user-accepted-tab" tabindex="0">
                        <div class="alert alert-info">
                            Немає прийнятих заявок
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>