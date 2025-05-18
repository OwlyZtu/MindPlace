<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\QuestionnaireForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\forms\FormOptions;

$this->title = 'Selection questionnaire';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-questionnaire container-fluid">
    <?php if (Yii::$app->session->hasFlash('questionnaireFormSubmitted')): ?>
        <?php $this->redirect('site/specialists'); ?>


    <?php else: ?>
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
                <p class="lead">
                    Let us know a bit about yourself and your preferences, so we can find the best match for you.
                </p>
                <div class="alert alert-info" role="alert">
                    <strong>Note:</strong> This questionnaire is not mandatory, but it will help us to find the best match
                    for you.
                </div>
            </div>

        </div>


        <div class="row ">
            <div class="col-lg-6 mx-auto questionnaire-form">

                <?php

                $form = ActiveForm::begin([
                    'id' => 'questionnaire-form',
                    'options' => ['class' => 'dynamic-form'],
                ]); ?>

                <fieldset class="border p-3 mb-3">
                    <?= $form->field($model, 'format')->radioList(FormOptions::getFormatOptions()) ?>

                    <div id="city-field" style="display: none;">
                        <?= $form->field($model, 'city')->dropDownList(FormOptions::getCityOptions()) ?>
                    </div>

                    <?= $form->field($model, 'therapy_types')->radioList(FormOptions::getTherapyTypesOptions()) ?>

                    <?= $form->field($model, 'theme')->checkboxList(FormOptions::getThemeOptions()) ?>

                    <?= $form->field($model, 'first_time')->radioList(FormOptions::getYesNoOptions()) ?>

                    <?= $form->field($model, 'approach')->radioList(FormOptions::getYesNoOptions()) ?>

                    <div id="approach-type-field" style="display: none;">
                        <?= $form->field($model, 'approach_type')->checkboxList(FormOptions::getApproachTypeOptions()) ?>
                    </div>

                    <?= $form->field($model, 'language')->radioList(FormOptions::getLanguageOptions()) ?>

                    <?= $form->field($model, 'gender')->radioList(FormOptions::getGenderOptions()) ?>

                    <?= $form->field($model, 'age')->checkboxList(FormOptions::getAgeOptions()) ?>

                    <?= $form->field($model, 'lgbt')->checkbox(['label' => 'LGBTQ+ friendly']) ?>

                    <?= $form->field($model, 'military')->checkbox(['label' => 'Work with military personnel']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('One moment', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </fieldset>


                <?php
                $script = <<<JS
                function toggleCity() {
                    var format = $('input[name="QuestionnaireForm[format]"]:checked').val();
                    if (format === 'offline') {
                        $('#city-field').show();
                    } else {
                        $('#city-field').hide();
                    }
                }
                function toggleApproachType() {
                    var approach = $('input[name="QuestionnaireForm[approach]"]:checked').val();
                    if (approach === 'yes') {
                        $('#approach-type-field').show();
                    } else {
                        $('#approach-type-field').hide();
                    }
                }
                $('input[name="QuestionnaireForm[format]"]').change(toggleCity);
                $('input[name="QuestionnaireForm[approach]"]').change(toggleApproachType);
                // Викликати при завантаженні
                toggleCity();
                toggleApproachType();
                JS;
                $this->registerJs($script);
                ?>


            </div>
        </div>

    <?php endif; ?>
</div>
</div>
<style>
    .alert-info {
        background-color: rgb(191, 190, 123);
        color: #54715D;
        border-color: #747D4A;
    }

    .questionnaire-form fieldset {
        border: 5px solid #507263;
        border-radius: 20px;
        background-color: rgba(80, 114, 99, 0.35);
    }
</style>