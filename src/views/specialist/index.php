<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\forms\FilterForm $model */


use yii\bootstrap5\Html;
use yii\widgets\LinkPager;
use app\services\PhotoService;

$this->title = Yii::t('specialist', 'Our specialists');
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = ['name' => 'description', 'content' => 'Our specialists'];
$this->params['meta_keywords'] = ['name' => 'keywords', 'content' => 'Our specialists'];

?>
<div class="site-specialists">
    <div class="body-content container-fluid row row-gap-2 justify-content-center mx-auto row">
        <div class="gradient-text-alt mt-4">
            <div class="specialists-header text-center">
                <h1><?= Html::encode($this->title) ?></h1>
                <p><?= Yii::t('specialist', 'Find the right specialist for your needs.') ?></p>
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
                    <span><?= Yii::t('specialist', 'Filter') ?></span>
                </button>
            </div>

            <div class="offcanvas offcanvas-end" id="filter-offcanvas" tabindex="-1" aria-labelledby="filterOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="filterOffcanvasLabel"><?= Yii::t('specialist', 'Filter') ?></h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body overflow-y-auto">
                    <?= $this->render('_filter_form', ['model' => $model]) ?>
                </div>
            </div>
        </div>

        <!-- Specialists List -->
        <div class="col-12 col-md-10 col-lg-9 my-1">
            <div class="row row-gap-3 justify-content-center">
                <?php if (empty($dataProvider->getModels())): ?>
                    <div class="alert alert-info" role="alert">
                        <?= Yii::t('specialist', 'No specialists found. Please try again later.') ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($dataProvider->getModels() as $specialist): ?>
                        <div class="card col-12 col-md-4 col-lg-3 mx-2">
                            <div class="card-header text-center">
                                <img src="<?= PhotoService::checkImageUrl($specialist->photo_url) ?>" class="img-fluid rounded" alt="doctor <?= Html::encode($specialist->name) ?> photo">
                                <h5 class="card-title mt-3"><?= Html::encode($specialist->name) ?></h5>
                            </div>
                            <div class="card-body text-center">
                                <p>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_icurrentColoronCarrier">
                                            <path d="M7 7C7 3.68629 8.93658 2 11.8718 2C13.7242 2 15.1788 2.6716 16 4" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                            <path d="M12 12V14.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                            <path d="M9.26556 20.6154L9.72058 20.0192L9.26556 20.6154ZM12 8.93062L11.4681 9.4594C11.6089 9.601 11.8003 9.68062 12 9.68062C12.1997 9.68062 12.3911 9.601 12.5319 9.4594L12 8.93062ZM14.7344 20.6154L15.1895 21.2116L14.7344 20.6154ZM7.53898 18.3638C7.21503 18.1057 6.74316 18.159 6.48504 18.483C6.22692 18.8069 6.28028 19.2788 6.60423 19.5369L7.53898 18.3638ZM3.247 15.8789C3.45073 16.2395 3.90825 16.3667 4.2689 16.163C4.62954 15.9593 4.75674 15.5017 4.553 15.1411L3.247 15.8789ZM3.75 12.0992C3.75 10.2748 4.81485 8.7347 6.28482 8.08418C7.71357 7.4519 9.63741 7.61795 11.4681 9.4594L12.5319 8.40184C10.3127 6.16968 7.73658 5.8014 5.67779 6.7125C3.66023 7.60535 2.25 9.68634 2.25 12.0992H3.75ZM8.81054 21.2116C9.27099 21.563 9.76987 21.9413 10.2764 22.2279C10.7832 22.5146 11.3656 22.75 12 22.75V21.25C11.7344 21.25 11.4168 21.1496 11.015 20.9223C10.6129 20.6949 10.1946 20.3809 9.72058 20.0192L8.81054 21.2116ZM15.1895 21.2116C16.4684 20.2354 18.1188 19.1062 19.4129 17.6953C20.7329 16.2564 21.75 14.46 21.75 12.0992H20.25C20.25 13.9756 19.4584 15.4268 18.3076 16.6814C17.1309 17.964 15.6485 18.9742 14.2794 20.0192L15.1895 21.2116ZM21.75 12.0992C21.75 9.68634 20.3398 7.60535 18.3222 6.7125C16.2634 5.8014 13.6873 6.16968 11.4681 8.40184L12.5319 9.4594C14.3626 7.61795 16.2864 7.4519 17.7152 8.08418C19.1852 8.7347 20.25 10.2748 20.25 12.0992H21.75ZM14.2794 20.0192C13.8054 20.3809 13.3871 20.6949 12.985 20.9223C12.5832 21.1496 12.2656 21.25 12 21.25V22.75C12.6344 22.75 13.2168 22.5146 13.7236 22.2279C14.2301 21.9413 14.729 21.563 15.1895 21.2116L14.2794 20.0192ZM9.72058 20.0192C9.0015 19.4703 8.27708 18.9519 7.53898 18.3638L6.60423 19.5369C7.35199 20.1327 8.14487 20.7035 8.81054 21.2116L9.72058 20.0192ZM4.553 15.1411C4.05588 14.2611 3.75 13.2673 3.75 12.0992H2.25C2.25 13.5483 2.6342 14.7941 3.247 15.8789L4.553 15.1411Z" fill="currentColor"></path>
                                        </g>
                                    </svg>
                                    <?= Html::encode(implode(', ', $specialist->getOptionLabels('specialization', 'specialization'))) ?>
                                </p>
                                <hr class="border border-success border-1 opacity-75">
                                <p>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M8.7838 21.9999C7.0986 21.2478 5.70665 20.0758 4.79175 18.5068" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M14.8252 2.18595C16.5021 1.70882 18.2333 2.16305 19.4417 3.39724" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M4.0106 8.36655L3.63846 7.71539L4.0106 8.36655ZM6.50218 8.86743L7.15007 8.48962L6.50218 8.86743ZM3.2028 10.7531L2.55491 11.1309H2.55491L3.2028 10.7531ZM7.69685 3.37253L8.34474 2.99472V2.99472L7.69685 3.37253ZM8.53873 4.81624L7.89085 5.19405L8.53873 4.81624ZM10.4165 9.52517C10.6252 9.88299 11.0844 10.0039 11.4422 9.79524C11.8 9.58659 11.9209 9.12736 11.7123 8.76955L10.4165 9.52517ZM7.53806 12.1327C7.74672 12.4905 8.20594 12.6114 8.56376 12.4027C8.92158 12.1941 9.0425 11.7349 8.83384 11.377L7.53806 12.1327ZM4.39747 5.25817L3.74958 5.63598L4.39747 5.25817ZM11.8381 2.9306L12.486 2.55279V2.55279L11.8381 2.9306ZM14.3638 7.26172L15.0117 6.88391L14.3638 7.26172ZM16.0475 10.1491L16.4197 10.8003C16.5934 10.701 16.7202 10.5365 16.772 10.3433C16.8238 10.15 16.7962 9.94413 16.6954 9.77132L16.0475 10.1491ZM17.0153 5.75389C17.2239 6.11171 17.6831 6.23263 18.041 6.02397C18.3988 5.81531 18.5197 5.35609 18.311 4.99827L17.0153 5.75389ZM20.1888 9.7072L20.8367 9.32939V9.32939L20.1888 9.7072ZM6.99128 17.2497L7.63917 16.8719L6.99128 17.2497ZM16.9576 19.2533L16.5854 18.6021L16.9576 19.2533ZM13.784 15.3C13.9927 15.6578 14.4519 15.7787 14.8097 15.5701C15.1676 15.3614 15.2885 14.9022 15.0798 14.5444L13.784 15.3ZM20.347 8.48962C20.1383 8.1318 19.6791 8.01089 19.3213 8.21954C18.9635 8.4282 18.8426 8.88742 19.0512 9.24524L20.347 8.48962ZM8.98692 20.1803C9.35042 20.3789 9.80609 20.2452 10.0047 19.8817C10.2033 19.5182 10.0697 19.0626 9.70616 18.864L8.98692 20.1803ZM13.8888 19.5453C13.4792 19.6067 13.1969 19.9886 13.2583 20.3982C13.3197 20.8079 13.7015 21.0902 14.1112 21.0288L13.8888 19.5453ZM4.38275 9.0177C5.01642 8.65555 5.64023 8.87817 5.85429 9.24524L7.15007 8.48962C6.4342 7.26202 4.82698 7.03613 3.63846 7.71539L4.38275 9.0177ZM3.63846 7.71539C2.44761 8.39597 1.83532 9.8969 2.55491 11.1309L3.85068 10.3753C3.64035 10.0146 3.75139 9.37853 4.38275 9.0177L3.63846 7.71539ZM7.04896 3.75034L7.89085 5.19405L9.18662 4.43843L8.34474 2.99472L7.04896 3.75034ZM7.89085 5.19405L10.4165 9.52517L11.7123 8.76955L9.18662 4.43843L7.89085 5.19405ZM8.83384 11.377L7.15007 8.48962L5.85429 9.24524L7.53806 12.1327L8.83384 11.377ZM7.15007 8.48962L5.04535 4.88036L3.74958 5.63598L5.85429 9.24524L7.15007 8.48962ZM5.57742 3.5228C6.21109 3.16065 6.8349 3.38327 7.04896 3.75034L8.34474 2.99472C7.62887 1.76712 6.02165 1.54123 4.83313 2.22048L5.57742 3.5228ZM4.83313 2.22048C3.64228 2.90107 3.02999 4.40199 3.74958 5.63598L5.04535 4.88036C4.83502 4.51967 4.94606 3.88363 5.57742 3.5228L4.83313 2.22048ZM11.1902 3.30841L13.7159 7.63953L15.0117 6.88391L12.486 2.55279L11.1902 3.30841ZM13.7159 7.63953L15.3997 10.5269L16.6954 9.77132L15.0117 6.88391L13.7159 7.63953ZM9.71869 3.08087C10.3524 2.71872 10.9762 2.94134 11.1902 3.30841L12.486 2.55279C11.7701 1.32519 10.1629 1.0993 8.9744 1.77855L9.71869 3.08087ZM8.9744 1.77855C7.78355 2.45914 7.17126 3.96006 7.89085 5.19405L9.18662 4.43843C8.97629 4.07774 9.08733 3.4417 9.71869 3.08087L8.9744 1.77855ZM15.5437 5.52635C16.1774 5.1642 16.8012 5.38682 17.0153 5.75389L18.311 4.99827C17.5952 3.77068 15.988 3.54478 14.7994 4.22404L15.5437 5.52635ZM14.7994 4.22404C13.6086 4.90462 12.9963 6.40555 13.7159 7.63953L15.0117 6.88391C14.8013 6.52322 14.9124 5.88718 15.5437 5.52635L14.7994 4.22404ZM2.55491 11.1309L6.34339 17.6276L7.63917 16.8719L3.85068 10.3753L2.55491 11.1309ZM19.5409 10.085C21.1461 12.8377 19.9501 16.6792 16.5854 18.6021L17.3297 19.9045C21.2539 17.6618 22.9512 12.9554 20.8367 9.32939L19.5409 10.085ZM15.0798 14.5444C14.4045 13.3863 14.8772 11.6818 16.4197 10.8003L15.6754 9.49797C13.5735 10.6993 12.5995 13.2687 13.784 15.3L15.0798 14.5444ZM19.0512 9.24524L19.5409 10.085L20.8367 9.32939L20.347 8.48962L19.0512 9.24524ZM9.70616 18.864C8.85353 18.3981 8.13826 17.7278 7.63917 16.8719L6.34339 17.6276C6.98843 18.7337 7.90969 19.5917 8.98692 20.1803L9.70616 18.864ZM16.5854 18.6021C15.7158 19.0991 14.7983 19.409 13.8888 19.5453L14.1112 21.0288C15.2038 20.865 16.2984 20.4939 17.3297 19.9045L16.5854 18.6021Z" fill="currentColor"></path>
                                        </g>
                                    </svg>
                                    <?= Html::encode(implode(', ', $specialist->getOptionLabels('format', 'format'))) ?>
                                </p>
                                <hr class="border border-success border-1 opacity-75">
                                <p>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_icurrentColoronCarrier">
                                            <path d="M8 10.5H16" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                            <path d="M8 14H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                            <path d="M17 3.33782C15.5291 2.48697 13.8214 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22C17.5228 22 22 17.5228 22 12C22 10.1786 21.513 8.47087 20.6622 7" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                        </g>
                                    </svg>
                                    <?= Html::encode(implode(', ', $specialist->getOptionLabels('language', 'language'))) ?>
                                </p>
                            </div>
                            <div class="card-footer text-center">
                                <a href=<?= "/specialist/" . $specialist->id ?> class="btn btn-primary"><?=Yii::t('specialist', 'View')?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?= Html::tag(
                        'nav',
                        LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => ['class' => 'pagination justify-content-center mt-3'],
                            'linkContainerOptions' => ['class' => 'page-item'],
                            'linkOptions' => ['class' => 'page-link'],
                            'activePageCssClass' => 'active',
                            'disabledPageCssClass' => ' page-link disabled',
                            'prevPageLabel' =>
                            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g><g id="SVGRepo_icurrentColoronCarrier"> <path d="M4 12L10 6M4 12L10 18M4 12H14.5M20 12H17.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path> </g></svg>',
                            'nextPageLabel' =>
                            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g><g id="SVGRepo_icurrentColoronCarrier"> <path d="M4 12H6.5M20 12L14 6M20 12L14 18M20 12H9.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round" stroke-linejoin="round"></path> </g></svg>',
                            'maxButtonCount' => 9,
                        ]),
                        ['aria-label' => 'Pagination']
                    );
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if ($filter): ?>
    <?php
    foreach ($filter as $key => $value) {
        if (property_exists($model, $key)) {
            $model->$key = $value;
        }
    }
    ?>
<?php endif; ?>