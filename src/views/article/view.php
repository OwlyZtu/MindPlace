<?php

/** @var yii\web\View $this */
/** @var app\models\Article $model */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('article', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="article-view container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10">
            <div class="article-card-view p-4 rounded-4 shadow">
                <?php if (
                    !Yii::$app->user->isGuest
                ): ?>
                    <?php if (
                        Yii::$app->user->identity->isSpecialist()
                        || $model->doctor_id === Yii::$app->user->identity->id
                    ): ?>
                        <div class="row justify-content-end">
                            <?= Html::a(Yii::t('article', 'Edit article'), ['update-article', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary col-md-2 me-1']) ?>
                            <?= Html::a(Yii::t('article', 'Delete article'), ['delete-article', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-danger  col-md-2',
                                'data' => [
                                    'confirm' => Yii::t('article', 'Are you sure you want to delete this article?'),
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <h1 class="mb-3"><?= Html::encode($model->title) ?></h1>
                <p class="text-muted"><?= Yii::$app->formatter->asDatetime($model->updated_at, 'php:d.m.Y H:i') ?></p>

                <hr>
                <div class="article-content">
                    <?= $model->content ?>
                </div>
                <hr>
                <p class="text-end text-muted">
                    <?= Yii::t('article', 'Author') ?>: <?= Html::a(Html::encode($model->doctor->name), ['/specialist/' . $model->doctor->id], ['class' => 'link text-white'])  ?? Yii::t('article', 'Unknown author') ?>

                </p>
            </div>
        </div>
    </div>
</div>