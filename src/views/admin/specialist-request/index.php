<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\Html;
use app\models\User;
use yii\widgets\LinkPager;

$this->title = Yii::t('admin', 'Specialist requests');
$columns = [
    'id',
    [
        'label' => Yii::t('admin', 'Name'),
        'attribute' => 'name',
        'value' => function ($model) {
            return Html::a($model->user->name, ['view', 'id' => $model->id], ['class' => 'link']);
        },
        'format' => 'raw',
    ],
    [
        'label' => Yii::t('admin', 'Specialization'),
        'attribute' => 'specialization',
        'value' => function ($model) {
            return Html::encode(implode(', ', $model->user->getOptionLabels('specialization', 'specialization')));
        },
        'format' => 'raw',
    ],
    [
        'label' => Yii::t('admin', 'City'),
        'attribute' => 'city',
        'value' => function ($model) {
            return Html::encode($model->user->getOptionLabel('city', 'city'));
        },
        'format' => 'raw',
    ],
    [
        'label' => Yii::t('admin', 'Comment'),
        'attribute' => 'comment',
        'value' => function ($model) {
            return Html::encode($model->comment) ?? Yii::t('admin', 'No comment');
        },
    ],
    'created_at:datetime',
]
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
                        <button class="btn active" id="tab-pending" data-bs-toggle="pill" data-bs-target="#pane-pending" type="button" role="tab">
                            <?= Yii::t('admin', 'Pending') ?>
                        </button>
                        <button class="btn" id="tab-rejected" data-bs-toggle="pill" data-bs-target="#pane-rejected" type="button" role="tab">
                            <?= Yii::t('admin', 'Rejected') ?>
                        </button>
                        <button class="btn" id="tab-approved" data-bs-toggle="pill" data-bs-target="#pane-approved" type="button" role="tab">
                            <?= Yii::t('admin', 'Approved') ?>
                        </button>
                        <button class="btn" id="tab-blocked" data-bs-toggle="pill" data-bs-target="#pane-blocked" type="button" role="tab">
                            <?= Yii::t('admin', 'Blocked') ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <?php foreach (
                        [
                            'pending' => Yii::t('admin', 'Pending'),
                            'rejected' => Yii::t('admin', 'Rejected'),
                            'approved' => Yii::t('admin', 'Approved'),
                            'blocked' => Yii::t('admin', 'Blocked'),
                        ] as $key => $label
                    ): ?>
                        <div class="tab-pane fade <?= $key === 'pending' ? 'show active' : '' ?>" id="pane-<?= $key ?>" role="tabpanel" aria-labelledby="tab-<?= $key ?>">
                            <?php
                            $provider = $providers[$key] ?? null;
                            $searchModel = $searchModels[$key];
                            if (!$provider || $provider->getTotalCount() === 0): ?>
                                <div class="alert alert-info mt-3">
                                    <?= Yii::t('admin', 'No with status') ?> <?= $label ?>
                                </div>
                            <?php else: ?>
                                <?php Pjax::begin(['id' => 'pjax-' . $key]); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $provider,
                                    'filterModel' => $searchModel,
                                    'summary' => false,
                                    'pager' => ['class' => yii\widgets\LinkPager::class, 'options' => ['class' => 'd-none']],
                                    'columns' => $columns,
                                ]); ?>
                                <?php Pjax::end(); ?>
                                <div class="row  justify-content-center">
                                    <?= Html::tag(
                                        'nav',
                                        LinkPager::widget([
                                            'pagination' => $provider->pagination,
                                            'options' => ['class' => 'pagination justify-content-center mt-3'],
                                            'linkContainerOptions' => ['class' => 'page-item'],
                                            'linkOptions' => ['class' => 'page-link'],
                                            'activePageCssClass' => 'active',
                                            'disabledPageCssClass' => ' page-link disabled',
                                            'prevPageLabel' =>
                                            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g><g id="SVGRepo_icurrentColoronCarrier"> <path d="M4 12L10 6M4 12L10 18M4 12H14.5M20 12H17.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path> </g></svg>',
                                            'nextPageLabel' =>
                                            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g><g id="SVGRepo_icurrentColoronCarrier"> <path d="M4 12H6.5M20 12L14 6M20 12L14 18M20 12H9.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path> </g></svg>',
                                            'maxButtonCount' => 9,
                                        ]),
                                        ['aria-label' => 'Pagination']
                                    );
                                    ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>