<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\Html;
use app\models\User;
use yii\widgets\LinkPager;
use yii\data\Pagination;

$this->title = 'User panel';

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
                            <?php Pjax::begin(); ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    'id',
                                    'username',
                                    'email',
                                    'city',
                                    [
                                        'attribute' => 'specialization',
                                        'filter' => User::getSpecializationList(),
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'filter' => User::getStatusList(),
                                        'value' => function ($model) {
                                            return User::getStatusList()[$model->status];
                                        },
                                    ],
                                    'created_at:datetime',
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>

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