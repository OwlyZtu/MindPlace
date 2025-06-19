<?php

/** @var yii\web\View $this */
/** @var app\models\Article $article */

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Перегляд статті: ' . $article->title;
$this->params['breadcrumbs'][] = ['label' => 'Управління статтями', 'url' => ['/admin/article-review']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10">
            <div class="article-card-view p-4 rounded-4 shadow">
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <?php if ($article->status == $article::STATUS_REVIEWING): ?>
                            <?= Html::a('Прийняти', ['approve', 'articleId' => $article->id], ['class' => 'btn btn-success mr-2']) ?>
                            <?= Html::a('Відхилити', ['reject', 'articleId' => $article->id], ['class' => 'btn btn-danger']) ?>
                        <?php elseif ($article->status == $article::STATUS_APPROVED): ?>
                            <?= Html::a('Відхилити', ['reject', 'articleId' => $article->id], ['class' => 'btn btn-danger mr-2']) ?>
                        <?php elseif ($article->status ==  $article::STATUS_REJECTED): ?>
                            <?= Html::a('Повторити', ['approve', 'articleId' => $article->id], ['class' => 'btn btn-info mr-2']) ?>

                        <?php endif; ?>

                    </div>
                </div>
                <div class="row">
                    <h1 class="mb-3"><?= Html::encode($article->title) ?></h1>
                    <p class="text-muted"><?= Yii::$app->formatter->asDate($article->updated_at) ?></p>

                    <hr>
                    <div class="article-content">
                        <?= $article->content ?>
                    </div>
                    <hr>
                    <p class="text-end text-muted">
                        Автор: <?= Html::encode($article->doctor->name ?? 'Невідомо') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>