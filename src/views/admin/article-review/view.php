<?php

/** @var yii\web\View $this */
/** @var app\models\Article $article */

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('admin', 'View article') . ': ' . $article->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Index blog'), 'url' => ['/admin/article-review']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10">
            <div class="article-card-view p-4 rounded-4 shadow">
                <div class="row justify-content-end">
                    <div class="col-md-4 text-end">
                        <?php if ($article->status == $article::STATUS_REVIEWING): ?>
                            <?= Html::a(Yii::t('admin', 'Approve'), ['approve', 'articleId' => $article->id], ['class' => 'btn btn-success mr-1']) ?>
                            <?= Html::a(Yii::t('admin', 'Reject'), ['reject', 'articleId' => $article->id], ['class' => 'btn btn-danger']) ?>

                        <?php elseif ($article->status == $article::STATUS_APPROVED): ?>
                            <?= Html::a(Yii::t('admin', 'Reject'), ['reject', 'articleId' => $article->id], ['class' => 'btn btn-danger']) ?>
                        <?php elseif ($article->status ==  $article::STATUS_REJECTED): ?>
                            <?= Html::a(Yii::t('admin', 'Approve'), ['approve', 'articleId' => $article->id], ['class' => 'btn btn-info']) ?>
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
                        <?= Yii::t('article', 'Author') ?>: <?= Html::encode($article->doctor->name ?? Yii::t('article', 'Unknown')) ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>