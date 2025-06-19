<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Блог твого ментального здоров\'я';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row article-index justify-content-center">


    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-12 col-md-11 col-lg-11 my-3">
        <div class="row row-gap-3 justify-content-center">
            <?php if (empty($dataProvider->getModels())): ?>
                <div class="alert alert-info" role="alert">
                    No articles found. Please try again later.
                </div>
            <?php else: ?>
                <?php
                $articles = $dataProvider->getModels();
                $chunks = array_chunk($articles, ceil(count($articles) / 2));
                ?>
                <div class="col-md-5">
                    <?php foreach ($chunks[0] as $article): ?>
                        <a href="<?= \yii\helpers\Url::to(['article/view', 'id' => $article->id]) ?>" class="text-decoration-none">
                            <div class=" article-card p-2 ps-5 mb-3 border border-2 border-success rounded-5 rounded-end-0">
                                <h5><?= $article->title ?></h5>
                                <small class="text-muted"><?= Yii::$app->formatter->asDate($article->updated_at) ?></small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="col-md-1 d-flex justify-content-center align-items-stretch">
                    <div class="border-start border-end border-2 border-success-subtle w-100"></div>
                </div>

                <div class="col-md-5">
                    <?php foreach ($chunks[1] as $article): ?>
                        <a href="<?= \yii\helpers\Url::to(['article/view', 'id' => $article->id]) ?>" class="text-decoration-none">
                            <div class="article-card p-2 mb-3 border border-2 border-success rounded-5 rounded-start-0">
                                <h5><?= $article->title ?></h5>
                                <small class="text-muted"><?= Yii::$app->formatter->asDate($article->updated_at) ?></small>
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