<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Schedule $session */

$this->title = Yii::t('session-cancel', 'Cancel session') . ' №' . $session->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('specialist', 'My sessions'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container my-5 text-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Yii::t('session-cancel', 'Are you sure you want to cancel this session?') . ' ' . Yii::$app->formatter->asDatetime($session->datetime, 'php:d.m.Y H:i') ?>?</p>
    <p> <?= Yii::t('session-cancel', 'Attention') ?> </p>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('session-cancel', 'Cancel'), ['class' => 'btn btn-danger']) ?>
        <?= Html::a(Yii::t('session-cancel', 'No'), ['session-details', 'id' => $session->id], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>