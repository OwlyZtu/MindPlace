<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\FilterForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\forms\FormOptions;
?>

<div class="filter-form">
    <?php $form = ActiveForm::begin(['id' => 'filter-form']); ?>

    <div class="form-group">

        <?= $form->field($model, 'format')->dropDownList(
            FormOptions::getFormatOptions(),
            ['promt' => 'Select format']
        ) ?>

        <div class="city-field" style="display: none;">
            <?= $form->field($model, 'city')->dropDownList(
                FormOptions::getCityOptions(),
                ['promt' => 'Select city']
            ) ?>
        </div>

        <?= $form->field($model, 'therapy_types')->dropDownList(
            FormOptions::getTherapyTypesOptions(),
            ['promt' => 'Therapy type']
        ) ?>

        <?= $form->field($model, 'theme')->checkboxList(
            FormOptions::getThemeOptions(),
            ['promt' => 'What theme to discuss']
        ) ?>

        <?= $form->field($model, 'approach_type')->checkboxList(
            FormOptions::getApproachTypeOptions()
        ) ?>

        <?= $form->field($model, 'language')->checkboxList(
            FormOptions::getLanguageOptions()
        ) ?>

        <?= $form->field($model, 'gender')->radioList(
            FormOptions::getGenderOptions()
        )->label('Therapist') ?>

        <?= $form->field($model, 'age')->checkboxList(
            FormOptions::getAgeOptions()
        ) ?>

        <?= $form->field($model, 'specialization')->checkboxList(
            FormOptions::getSpecializationOptions()
        ) ?>


        <?= $form->field($model, 'lgbt')->checkbox(['label' => 'LGBTQ+ friendly']) ?>

        <?= $form->field($model, 'military')->checkbox(['label' => 'Work with military personnel']) ?>

        <div class="form-group">
            <?= Html::submitButton('One moment', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>


        <?php
        $script = <<<JS
        function toggleCity() {
            $('.filter-form select[id$="-format"]').each(function() {
                var formatSelect = $(this);
                var formGroup = formatSelect.closest('.filter-form');
                var cityField = formGroup.find('.city-field');
                
                if (formatSelect.val() === 'offline') {
                    cityField.show();
                } else {
                    cityField.hide();
                }
            });
        }

        $('.filter-form select[id$="-format"]').change(toggleCity);

        toggleCity();
        JS;
        Yii::$app->view->registerJs($script);
        ?>
    </div>
</div>