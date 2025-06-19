<?php

/** @var yii\web\View $this */
/** @var app\models\Article $model */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статті', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="article-view container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10">
            <div class="article-card-view p-4 rounded-4 shadow">
                <?php if (
                    !Yii::$app->user->isGuest
                    && (!Yii::$app->user->identity->isSpecialist()
                        || $model->doctor_id === Yii::$app->user->identity->id)
                ): ?>
                    <div class="row justify-content-end">
                        <?= Html::a('Редагувати', ['update-article', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary col-md-2 me-1']) ?>

                        <?= Html::a('Видалити', ['delete-article', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger  col-md-2',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this article?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                <?php endif; ?>
                <h1 class="mb-3"><?= Html::encode($model->title) ?></h1>
                <p class="text-muted"><?= Yii::$app->formatter->asDate($model->updated_at) ?></p>

                <hr>
                <div class="article-content">
                    <?= $model->content ?>
                </div>
                <hr>
                <p class="text-end text-muted">
                    Автор: <?= Html::encode($model->doctor->name ?? 'Невідомо') ?>
                </p>
            </div>
        </div>
    </div>
</div>