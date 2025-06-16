<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserProfileForm $model */
/** @var string|null $birthDateFromGoogle */

$form = ActiveForm::begin();

echo $form->field($model, 'birth_date')->input('date')->label('Дата народження');

if ($birthDateFromGoogle === null) {
    echo "<p>Дата народження не знайдена у профілі Google. Будь ласка, введіть її вручну.</p>";
} else {
    echo "<p>Дата народження отримана з Google: <b>" . Html::encode($model->birth_date) . "</b></p>";
}

echo Html::submitButton('Зберегти', ['class' => 'btn btn-primary']);

ActiveForm::end();
