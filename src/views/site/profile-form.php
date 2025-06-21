<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserProfileForm $model */
/** @var string|null $birthDateFromGoogle */

$form = ActiveForm::begin();

echo $form->field($model, 'birth_date')->input('date')->label('Дата народження');

if ($birthDateFromGoogle === null) {
    echo "<p>" . Yii::t('profile', 'Birth date not found in Google profile. Please enter it manually.') . "</p>";
} else {
    echo "<p>" . Yii::t('profile', 'Birth date obtained from Google:') . " <b>" . Html::encode($model->birth_date) . "</b></p>";
}

echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']);

ActiveForm::end();
