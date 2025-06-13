<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\Html;
use app\models\User;
use yii\widgets\LinkPager;

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
                        <button class="btn active" id="v-pills-user-pending-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-pending" type="button" role="tab" aria-controls="v-pills-user-pending" aria-selected="true">
                            В обробці
                        </button>
                        <button class="btn" id="v-pills-user-rejected-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-rejected" type="button" role="tab" aria-controls="v-pills-user-rejected" aria-selected="false">
                            Відхилено
                        </button>
                        <button class="btn" id="v-pills-user-approved-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-approved" type="button" role="tab" aria-controls="v-pills-user-approved" aria-selected="false">
                            Прийнято
                        </button>
                        <button class="btn" id="v-pills-user-new-tab" data-bs-toggle="pill" data-bs-target="#v-pills-user-blocked" type="button" role="tab" aria-controls="v-pills-user-blocked" aria-selected="false">
                            Заблоковано
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show bg-transparent active" id="v-pills-user-pending" role="tabpanel" aria-labelledby="v-pills-user-pending-tab" tabindex="0">
                        <?php
                        $pendingProvider = $providers['pending'];
                        ?>
                        <?php if ($pendingProvider['dataProvider']->getTotalCount() === 0): ?>
                            <div class="alert alert-info">
                                Немає заявок в обробці
                            </div>
                        <?php else: ?>
                            <?php Pjax::begin(['id' => 'pjax-pending']); ?>
                            <?= GridView::widget([
                                'dataProvider' => $pendingProvider['dataProvider'],
                                'filterModel' => $pendingProvider['searchModel'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{view}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('Переглянути', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                            },
                                        ],
                                    ],
                                    'id',
                                    [
                                        'attribute' => 'name',
                                        'value' => 'user.name',
                                    ],
                                    [
                                        'attribute' => 'specialization',
                                        'value' => 'user.specialization',
                                    ],
                                    [
                                        'attribute' => 'city',
                                        'value' => 'user.city',
                                    ],
                                    'comment',
                                    
                                    'updated_at:datetime',
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>
                        <?php endif; ?>

                    </div>
                    <div class="tab-pane fade bg-transparent" id="v-pills-user-rejected" role="tabpanel" aria-labelledby="v-pills-user-rejected-tab" tabindex="0">
                        <?php
                        $rejectedProvider  = $providers['rejected'];
                        ?>
                        <?php if ($rejectedProvider['dataProvider']->getTotalCount() === 0): ?>
                            <div class="alert alert-info">
                                Немає відхилених заявок
                            </div>
                        <?php else: ?>
                            <?php Pjax::begin(['id' => 'pjax-rejected']); ?>
                            <?= GridView::widget([
                                'dataProvider' => $rejectedProvider['dataProvider'],
                                'filterModel' => $rejectedProvider['searchModel'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{view}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('Переглянути', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                            },
                                        ],
                                    ],
                                    'id',
                                    [
                                        'attribute' => 'name',
                                        'value' => 'user.name',
                                    ],
                                    [
                                        'attribute' => 'specialization',
                                        'value' => 'user.specialization',
                                    ],
                                    [
                                        'attribute' => 'city',
                                        'value' => 'user.city',
                                    ],
                                    'comment',
                                    'updated_at:datetime',
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade bg-transparent" id="v-pills-user-approved" role="tabpanel" aria-labelledby="v-pills-user-approved-tab" tabindex="0">
                        <?php
                        $approvedProvider  = $providers['approved'];
                        ?>
                        <?php if ($approvedProvider['dataProvider']->getTotalCount() === 0): ?>
                            <div class="alert alert-info">
                                Немає прийнятих заявок
                            </div>
                        <?php else: ?>
                            <?php Pjax::begin(['id' => 'pjax-approved']); ?>
                            <?= GridView::widget([
                                'dataProvider' => $approvedProvider['dataProvider'],
                                'filterModel' => $approvedProvider['searchModel'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{view}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('Переглянути', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                            },
                                        ],
                                    ],
                                    'id',
                                    [
                                        'attribute' => 'name',
                                        'value' => 'user.name',
                                    ],
                                    [
                                        'attribute' => 'specialization',
                                        'value' => 'user.specialization',
                                    ],
                                    [
                                        'attribute' => 'city',
                                        'value' => 'user.city',
                                    ],
                                    'comment',
                                    
                                    'updated_at:datetime',
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade bg-transparent" id="v-pills-user-blocked" role="tabpanel" aria-labelledby="v-pills-user-blocked-tab" tabindex="0">
                        <?php
                        $blockedProvider  = $providers['blocked'];
                        ?>
                        <?php if ($blockedProvider['dataProvider']->getTotalCount() === 0): ?>
                            <div class="alert alert-info">
                            Немає заблокованих користувачів
                            </div>
                        <?php else: ?>
                            <?php Pjax::begin(['id' => 'pjax-blocked']); ?>
                            <?= GridView::widget([
                                'dataProvider' => $blockedProvider['dataProvider'],
                                'filterModel' => $blockedProvider['searchModel'],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{view}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('Переглянути', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                            },
                                        ],
                                    ],
                                    'id',
                                    [
                                        'attribute' => 'name',
                                        'value' => 'user.name',
                                    ],
                                    [
                                        'attribute' => 'specialization',
                                        'value' => 'user.specialization',
                                    ],
                                    [
                                        'attribute' => 'city',
                                        'value' => 'user.city',
                                    ],
                                    'comment',
                                    
                                    'updated_at:datetime',
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>