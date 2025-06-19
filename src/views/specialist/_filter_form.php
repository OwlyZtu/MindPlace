<?php

/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\FilterForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use app\models\forms\FormOptions;
?>

<div class="filter-form">
    <?php $form = ActiveForm::begin(['id' => 'filter-form']); ?>

    <div class="form-group">

        <?= $form->field($model, 'format')->dropDownList(
            FormOptions::getFormatOptions(),
            ['promt' => 'Select format']
        )->label(Yii::t('specialist', 'Format')) ?>

        <div class="city-field" style="display: none;">
            <?= $form->field($model, 'city')->dropDownList(
                FormOptions::getCityOptions(),
                ['promt' => 'Select city']
            )->label(Yii::t('specialist', 'City')) ?>
        </div>

        <?= $form->field($model, 'therapy_types')->dropDownList(
            FormOptions::getTherapyTypesOptions(),
            ['promt' => 'Therapy type']
        )->label(Yii::t('specialist', 'Therapy type')) ?>

        <?= $form->field($model, 'theme')->checkboxList(
            FormOptions::getThemeOptions(),
            ['promt' => 'What theme to discuss']
        )->label(Yii::t('specialist', 'Theme')) ?>

        <?= $form->field($model, 'approach_type')->checkboxList(
            FormOptions::getApproachTypeOptions()
        )->label(Yii::t('specialist', 'Approach type')) ?>

        <?= $form->field($model, 'language')->checkboxList(
            FormOptions::getLanguageOptions()
        )->label(Yii::t('specialist', 'Language')) ?>

        <?= $form->field($model, 'gender')->radioList(
            FormOptions::getGenderOptions()
        )->label(Yii::t('specialist', 'Gender')) ?>

        <?= $form->field($model, 'age')->checkboxList(
            FormOptions::getAgeOptions()
        )->label(Yii::t('specialist', 'Age')) ?>

        <?= $form->field($model, 'specialization')->checkboxList(
            FormOptions::getSpecializationOptions()
        )->label(Yii::t('specialist', 'Specialization')) ?>


        <?= $form->field($model, 'lgbt')->checkbox()->label(Yii::t('specialist', 'LGBTQ+ friendly')) ?>

        <?= $form->field($model, 'military')->checkbox()->label(Yii::t('specialist', 'Work with military personnel')) ?>

        <div class="btn-group">
            <?= Html::submitButton(Yii::t('specialist', 'Apply'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(
                '<span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                </span>',
                ['site/specialists', 'clear' => 1],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>



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