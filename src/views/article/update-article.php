<?php

/** @var yii\web\View $this */
/** @var app\models\Article $model */

use app\models\ArticleForm;
use yii\widgets\ActiveForm;

use yii\helpers\Html;

$this->title = Yii::t('article', 'Edit article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('article', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="article-create container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 ">
            <div class="p-4 rounded-4 shadow article-card-view">
                <h2 class="mb-4"><?= Html::encode($this->title) ?></h2>

                <div class="article-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'value' => $article->title])->label(Yii::t('article', 'Article title')) ?>

                    <?= $form->field($model, 'content')->textarea(['id' => 'articleform-content-update'])->label(Yii::t('article', 'Article content')) ?>

                    <div class="alert alert-info">
                        <p>
                            <?= Yii::t('article', 'Before update') ?>
                        </p>
                    </div>
                    <div class="form-group mt-3">
                        <?= Html::submitButton(Yii::t('article', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = json_encode($article->content);
$js = <<<JS
    tinymce.init({
        selector: 'textarea#articleform-content-update',

        menubar: false,
        plugins: [
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons',
            'image', 'link', 'lists', 'media', 'searchreplace',
            'table', 'visualblocks', 'wordcount'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        init_instance_callback: function (editor) {
            editor.setContent($content);
        }
    });
JS;

$this->registerJs($js);
?>