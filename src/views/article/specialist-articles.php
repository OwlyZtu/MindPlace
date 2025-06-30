<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('article', 'Specialist articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row article-index justify-content-center">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-12 col-md-10 col-lg-10 my-3">
        <div class="row justify-content-end mb-3">
            <div class="col-12 col-md-3 col-lg-3">
                <a href="<?= \yii\helpers\Url::to(['article/create-article']) ?>" class="btn btn-success text-center"><?= Yii::t('article', 'Create article') ?></a>
            </div>
        </div>
        <div class="row row-gap-3 justify-content-center">
            <?php if (empty($dataProvider->getModels())): ?>
                <div class="alert alert-info" role="alert">
                    <?= Yii::t('article', 'No articles found') ?>
                </div>
            <?php else: ?>
                <?php
                $articles = $dataProvider->getModels();
                foreach ($articles as $article): ?>
                    <a href="<?= \yii\helpers\Url::to(['article/view', 'id' => $article->id]) ?>" class="text-decoration-none">
                        <div class="article-card p-2 mb-3 border border-2 border-success rounded-5 rounded-start-0">
                            <h5><?= $article->title ?></h5>
                            <small class="text-muted"><?= Yii::$app->formatter->asDatetime($article->updated_at, 'php:d.m.Y H:i') ?></small>
                        </div>
                    </a>
                <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
</div>

<div class="row  justify-content-center">
    <?= Html::tag(
        'nav',
        LinkPager::widget([
            'pagination' => $dataProvider->pagination,
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
</div>