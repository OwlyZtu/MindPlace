<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Yii::t('app', 'Contact') ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <div class="alert alert-success">
            <?= Yii::t('app', 'Thank you for contacting us. We will reply to you as soon as possible.') ?>
        </div>
    <?php else: ?>

        <p>
            <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you. We will reply to you as soon as possible.') ?>
        </p>

        <div class="row justify-content-center">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label(Yii::t('app', 'Your name')) ?>

                    <?= $form->field($model, 'email')->textInput()->label(Yii::t('app', 'Your email')) ?>

                    <?= $form->field($model, 'subject')->textInput()->label(Yii::t('app', 'Subject')) ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6])->label(Yii::t('app', 'Your message')) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
