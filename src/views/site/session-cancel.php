<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Schedule $session */

$this->title = 'Підтвердження скасування запису №' . $session->id;
$this->params['breadcrumbs'][] = ['label' => 'Мої сесії', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container my-5 text-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Ви дійсно хочете скасувати запис на сесію, що відбудеться <?= Yii::$app->formatter->asDatetime($session->datetime, ' d/m/Y H:i ') ?>?</p>
    <p> Зауважте, що скасований запис не можна буде відновити, а також ця дія можлива тільки якщо до запису залишилося більше години</p>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton('Так, скасувати запис', ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Ні, повернутись назад', ['session-details', 'id' => $session->id], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>