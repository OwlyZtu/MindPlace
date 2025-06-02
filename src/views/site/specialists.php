<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\FilterForm $model */


use yii\bootstrap5\Html;

$this->title = 'Our specialists';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = ['name' => 'description', 'content' => 'Our specialists'];
$this->params['meta_keywords'] = ['name' => 'keywords', 'content' => 'Our specialists'];

?>
<div class="site-specialists">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="gradient-text-alt mt-4">
            <div class="specialists-header text-center">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>Find the right specialist for your needs.</p>
            </div>
        </div>
        <!-- Filter -->
        <div class="col-lg-3 mb-3">
            <div class="row row-gap-5"></div>
            <!-- Large screen filter -->
            <div class="d-none d-lg-block ">
                <?= $this->render('_filter_form', ['model' => $model]) ?>
            </div>

            <!-- Small screen filter -->
            <div class="d-block d-lg-none row mx-auto">
                <button class="btn btn-primary btn-lg me-2" data-bs-toggle="offcanvas" role="button" data-bs-target="#filter-offcanvas" aria-controls="filter-offcanvas">
                    <span>Filter</span>
                </button>
            </div>

            <div class="offcanvas offcanvas-end" id="filter-offcanvas" tabindex="-1" aria-labelledby="filterOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filter</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body overflow-y-auto">
                    <?= $this->render('_filter_form', ['model' => $model]) ?>
                </div>
            </div>
        </div>

        <!-- Specialists List -->
        <div class="col-12 col-md-10 col-lg-9 my-3">
            <div class="row row-gap-5">
                <?php if (empty($specialists)): ?>
                    <div class="alert alert-info" role="alert">
                        No specialists found. Please try again later.
                    </div>
                <?php else: ?>
                    <?php foreach ($specialists as $specialist): ?>
                        <div class="card col-12 col-md-4 col-lg-3 mb-3">
                            <div class="card-header text-center">
                                <img src="https://i.pinimg.com/736x/2a/a8/be/2aa8be1d8d116f8666196e1e80e6cc8b.jpg" alt="Avatar"
                                    class="card-img-top rounded">
                                <h4 class="card-title"><?= Html::encode($specialist->username) ?></h4>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= Html::encode($specialist->specialization) ?></h5>
                                <p class="card-text"><?= Html::encode((implode(', ', $specialist->type))) ?></p>
                                <p class="card-text">Experience: <?= Html::encode($specialist->experience) ?> years</p>
                            </div>
                            <div class="card-footer text-center">
                                <a href="#" class="btn btn-primary">View Profile</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if ($filter): ?>
    <?php
    // Встановлюємо значення фільтру в модель
    foreach ($filter as $key => $value) {
        if (property_exists($model, $key)) {
            $model->$key = $value;
        }
    }
    ?>
<?php endif; ?>