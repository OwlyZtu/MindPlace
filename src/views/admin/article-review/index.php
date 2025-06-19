<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap5\Html;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var array $providers */

$this->title = 'Blog panel';
?>
<div class="site-specialists">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="gradient-text-alt mt-4 text-center">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="row">
            <!-- Tabs -->
            <div class="col-md-2">
                <div class="nav-tabs flex-column me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="btn active" id="tab-reviewing" data-bs-toggle="pill" data-bs-target="#pane-reviewing" type="button" role="tab">
                        В обробці
                    </button>
                    <button class="btn" id="tab-rejected" data-bs-toggle="pill" data-bs-target="#pane-rejected" type="button" role="tab">
                        Відхилено
                    </button>
                    <button class="btn" id="tab-approved" data-bs-toggle="pill" data-bs-target="#pane-approved" type="button" role="tab">
                        Прийнято
                    </button>
                </div>
            </div>

            <!-- Tab content -->
            <div class="col-md-10 rounded-2">
                <div class="tab-content" id="v-pills-tabContent">
                    <?php foreach (['reviewing' => 'В обробці', 'rejected' => 'Відхилено', 'approved' => 'Прийнято'] as $key => $label): ?>
                        <div class="tab-pane fade <?= $key === 'reviewing' ? 'show active' : '' ?>" id="pane-<?= $key ?>" role="tabpanel" aria-labelledby="tab-<?= $key ?>">
                            <?php
                            $provider = $providers[$key] ?? null;
                            $searchModel = $searchModels[$key];
                            if (!$provider || $provider->getTotalCount() === 0): ?>
                                <div class="alert alert-info mt-3">
                                    Немає статей зі статусом: <?= $label ?>
                                </div>
                            <?php else: ?>
                                <?php Pjax::begin(['id' => 'pjax-' . $key]); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $provider,
                                    'filterModel' => $searchModel,
                                    'summary' => false,
                                    'pager' => ['class' => yii\widgets\LinkPager::class, 'options' => ['class' => 'd-none']],
                                    'columns' => [
                                        'id',
                                        [
                                            'attribute' => 'title',
                                            'value' => function ($model) {
                                                return Html::a(Html::encode($model->title), ['/admin/article-review/view', 'id' => $model->id], ['class' => 'link']);
                                            },
                                            'format' => 'raw',  
                                        ],
                                        [
                                            'attribute' => 'user.name',
                                            'label' => 'Автор',
                                            'value' => function ($model) {
                                                return $model->doctor
                                                    ? Html::a(Html::encode($model->doctor->name), ['/admin/article-review/redirect-to-specialist', 'id' => $model->doctor->id], ['class' => 'link'])
                                                    : '(немає даних)';
                                            },
                                            'format' => 'raw',
                                        ],
                                        [
                                            'attribute' => 'created_at',
                                            'label' => 'Дата створення',
                                            'format' => ['date', 'php:d.m.Y H:i'],
                                        ],
                                        [
                                            'attribute' => 'updated_at',
                                            'label' => 'Дата оновлення',
                                            'format' => ['date', 'php:d.m.Y H:i'],
                                        ],
                                    ],
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