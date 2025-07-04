<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\services\PhotoService;
use yii\helpers\Url;


/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var app\models\forms\AssignForm $assignForm */
/** @var app\models\forms\RatingForm $ratingForm */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('specialist', 'Specialists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-specialist row row-gap-4">
    <div class="specialist-profile row">
        <div class="col-md-4">
            <img src="<?= PhotoService::checkImageUrl($model->photo_url) ?>" class="img-fluid rounded" alt="doctor <?= Html::encode($model->name) ?> photo">
        </div>
        <div class="col-md-8">
            <h1><?= Html::encode($model->name) ?></h1>
            <p><i>
                    <?= Html::encode(implode(', ', $model->getOptionLabels('specialization', 'specialization'))) ?>
                </i></p>
            <div class="row">
                <div class="col-md-5">
                    <p>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_icurrentColoronCarrier">
                                <path d="M14 4C14 5.10457 13.1046 6 12 6C10.8954 6 10 5.10457 10 4C10 2.89543 10.8954 2 12 2C13.1046 2 14 2.89543 14 4Z" stroke="currentColor" stroke-width="1.5"></path>
                                <path d="M6.04779 10.849L6.28497 10.1375H6.28497L6.04779 10.849ZM8.22309 11.5741L7.98592 12.2856H7.98592L8.22309 11.5741ZM9.01682 13.256L8.31681 12.9868H8.31681L9.01682 13.256ZM7.77003 16.4977L8.47004 16.7669H8.47004L7.77003 16.4977ZM17.9522 10.849L17.715 10.1375H17.715L17.9522 10.849ZM15.7769 11.5741L16.0141 12.2856H16.0141L15.7769 11.5741ZM14.9832 13.256L15.6832 12.9868L14.9832 13.256ZM16.23 16.4977L15.53 16.7669L16.23 16.4977ZM10.4242 17.7574L11.0754 18.1295L10.4242 17.7574ZM12 14.9997L12.6512 14.6276C12.5177 14.394 12.2691 14.2497 12 14.2497C11.7309 14.2497 11.4823 14.394 11.3488 14.6276L12 14.9997ZM17.1465 7.8969L16.9894 7.16355L17.1465 7.8969ZM15.249 8.30353L15.4061 9.03688V9.03688L15.249 8.30353ZM8.75102 8.30353L8.90817 7.57018V7.57018L8.75102 8.30353ZM6.85345 7.89691L6.69631 8.63026L6.85345 7.89691ZM13.5758 17.7574L12.9246 18.1295V18.1295L13.5758 17.7574ZM15.0384 8.34826L14.8865 7.61381L14.8865 7.61381L15.0384 8.34826ZM8.96161 8.34826L8.80969 9.08272L8.80969 9.08272L8.96161 8.34826ZM15.2837 11.7666L15.6777 12.4048L15.2837 11.7666ZM14.8182 12.753L15.5613 12.6514V12.6514L14.8182 12.753ZM8.71625 11.7666L8.3223 12.4048H8.3223L8.71625 11.7666ZM9.18177 12.753L9.92485 12.8546V12.8546L9.18177 12.753ZM10.3454 9.32206C10.7573 9.36558 11.1265 9.06692 11.17 8.655C11.2135 8.24308 10.9149 7.87388 10.503 7.83036L10.3454 9.32206ZM13.497 7.83036C13.0851 7.87388 12.7865 8.24308 12.83 8.655C12.8735 9.06692 13.2427 9.36558 13.6546 9.32206L13.497 7.83036ZM5.81062 11.5605L7.98592 12.2856L8.46026 10.8626L6.28497 10.1375L5.81062 11.5605ZM8.31681 12.9868L7.07002 16.2284L8.47004 16.7669L9.71683 13.5252L8.31681 12.9868ZM17.715 10.1375L15.5397 10.8626L16.0141 12.2856L18.1894 11.5605L17.715 10.1375ZM14.2832 13.5252L15.53 16.7669L16.93 16.2284L15.6832 12.9868L14.2832 13.5252ZM11.0754 18.1295L12.6512 15.3718L11.3488 14.6276L9.77299 17.3853L11.0754 18.1295ZM16.9894 7.16355L15.0918 7.57017L15.4061 9.03688L17.3037 8.63026L16.9894 7.16355ZM8.90817 7.57018L7.0106 7.16355L6.69631 8.63026L8.59387 9.03688L8.90817 7.57018ZM11.3488 15.3718L12.9246 18.1295L14.227 17.3853L12.6512 14.6276L11.3488 15.3718ZM15.0918 7.57017C14.9853 7.593 14.9356 7.60366 14.8865 7.61381L15.1903 9.08272C15.2458 9.07123 15.3016 9.05928 15.4061 9.03688L15.0918 7.57017ZM8.59387 9.03688C8.6984 9.05928 8.75416 9.07123 8.80969 9.08272L9.11353 7.61381C9.06443 7.60366 9.01468 7.593 8.90817 7.57018L8.59387 9.03688ZM9.14506 19.2497C9.94287 19.2497 10.6795 18.8222 11.0754 18.1295L9.77299 17.3853C9.64422 17.6107 9.40459 17.7497 9.14506 17.7497V19.2497ZM15.53 16.7669C15.7122 17.2406 15.3625 17.7497 14.8549 17.7497V19.2497C16.4152 19.2497 17.4901 17.6846 16.93 16.2284L15.53 16.7669ZM15.5397 10.8626C15.3178 10.9366 15.0816 11.01 14.8898 11.1283L15.6777 12.4048C15.6688 12.4102 15.6763 12.4037 15.7342 12.3818C15.795 12.3588 15.877 12.3313 16.0141 12.2856L15.5397 10.8626ZM15.6832 12.9868C15.6313 12.8519 15.6004 12.7711 15.5795 12.7095C15.5596 12.651 15.5599 12.6411 15.5613 12.6514L14.0751 12.8546C14.1057 13.0779 14.1992 13.3069 14.2832 13.5252L15.6832 12.9868ZM14.8898 11.1283C14.3007 11.492 13.9814 12.1687 14.0751 12.8546L15.5613 12.6514C15.5479 12.5534 15.5935 12.4567 15.6777 12.4048L14.8898 11.1283ZM18.25 9.39526C18.25 9.73202 18.0345 10.031 17.715 10.1375L18.1894 11.5605C19.1214 11.2499 19.75 10.3777 19.75 9.39526H18.25ZM7.07002 16.2284C6.50994 17.6846 7.58484 19.2497 9.14506 19.2497V17.7497C8.63751 17.7497 8.28784 17.2406 8.47004 16.7669L7.07002 16.2284ZM7.98592 12.2856C8.12301 12.3313 8.20501 12.3588 8.26583 12.3818C8.32371 12.4037 8.33115 12.4102 8.3223 12.4048L9.1102 11.1283C8.91842 11.01 8.68219 10.9366 8.46026 10.8626L7.98592 12.2856ZM9.71683 13.5252C9.80081 13.3069 9.89432 13.0779 9.92485 12.8546L8.43868 12.6514C8.44009 12.6411 8.4404 12.6509 8.42051 12.7095C8.3996 12.7711 8.36869 12.8519 8.31681 12.9868L9.71683 13.5252ZM8.3223 12.4048C8.40646 12.4567 8.45208 12.5534 8.43868 12.6514L9.92485 12.8546C10.0186 12.1687 9.69929 11.492 9.1102 11.1283L8.3223 12.4048ZM4.25 9.39526C4.25 10.3777 4.87863 11.2499 5.81062 11.5605L6.28497 10.1375C5.96549 10.031 5.75 9.73202 5.75 9.39526H4.25ZM5.75 9.39526C5.75 8.89717 6.20927 8.52589 6.69631 8.63026L7.0106 7.16355C5.58979 6.8591 4.25 7.9422 4.25 9.39526H5.75ZM12.9246 18.1295C13.3205 18.8222 14.0571 19.2497 14.8549 19.2497V17.7497C14.5954 17.7497 14.3558 17.6107 14.227 17.3853L12.9246 18.1295ZM19.75 9.39526C19.75 7.9422 18.4102 6.85909 16.9894 7.16355L17.3037 8.63026C17.7907 8.52589 18.25 8.89717 18.25 9.39526H19.75ZM10.503 7.83036C10.0374 7.78118 9.57371 7.709 9.11353 7.61381L8.80969 9.08272C9.31831 9.18792 9.83084 9.2677 10.3454 9.32206L10.503 7.83036ZM14.8865 7.61381C14.4263 7.709 13.9626 7.78118 13.497 7.83036L13.6546 9.32206C14.1692 9.2677 14.6817 9.18792 15.1903 9.08272L14.8865 7.61381Z" fill="currentColor"></path>
                                <path d="M19.4537 15C21.0372 15.7961 22 16.8475 22 18C22 18.7484 21.594 19.4541 20.8758 20.0749M4.54631 15C2.96285 15.7961 2 16.8475 2 18C2 20.4853 6.47715 22.5 12 22.5C13.8214 22.5 15.5291 22.2809 17 21.898" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                            </g>
                        </svg> <?= Html::encode($model->age) ?> <?= Yii::t('specialist', 'years old') ?>
                    </p>
                    <p>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M8.7838 21.9999C7.0986 21.2478 5.70665 20.0758 4.79175 18.5068" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M14.8252 2.18595C16.5021 1.70882 18.2333 2.16305 19.4417 3.39724" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M4.0106 8.36655L3.63846 7.71539L4.0106 8.36655ZM6.50218 8.86743L7.15007 8.48962L6.50218 8.86743ZM3.2028 10.7531L2.55491 11.1309H2.55491L3.2028 10.7531ZM7.69685 3.37253L8.34474 2.99472V2.99472L7.69685 3.37253ZM8.53873 4.81624L7.89085 5.19405L8.53873 4.81624ZM10.4165 9.52517C10.6252 9.88299 11.0844 10.0039 11.4422 9.79524C11.8 9.58659 11.9209 9.12736 11.7123 8.76955L10.4165 9.52517ZM7.53806 12.1327C7.74672 12.4905 8.20594 12.6114 8.56376 12.4027C8.92158 12.1941 9.0425 11.7349 8.83384 11.377L7.53806 12.1327ZM4.39747 5.25817L3.74958 5.63598L4.39747 5.25817ZM11.8381 2.9306L12.486 2.55279V2.55279L11.8381 2.9306ZM14.3638 7.26172L15.0117 6.88391L14.3638 7.26172ZM16.0475 10.1491L16.4197 10.8003C16.5934 10.701 16.7202 10.5365 16.772 10.3433C16.8238 10.15 16.7962 9.94413 16.6954 9.77132L16.0475 10.1491ZM17.0153 5.75389C17.2239 6.11171 17.6831 6.23263 18.041 6.02397C18.3988 5.81531 18.5197 5.35609 18.311 4.99827L17.0153 5.75389ZM20.1888 9.7072L20.8367 9.32939V9.32939L20.1888 9.7072ZM6.99128 17.2497L7.63917 16.8719L6.99128 17.2497ZM16.9576 19.2533L16.5854 18.6021L16.9576 19.2533ZM13.784 15.3C13.9927 15.6578 14.4519 15.7787 14.8097 15.5701C15.1676 15.3614 15.2885 14.9022 15.0798 14.5444L13.784 15.3ZM20.347 8.48962C20.1383 8.1318 19.6791 8.01089 19.3213 8.21954C18.9635 8.4282 18.8426 8.88742 19.0512 9.24524L20.347 8.48962ZM8.98692 20.1803C9.35042 20.3789 9.80609 20.2452 10.0047 19.8817C10.2033 19.5182 10.0697 19.0626 9.70616 18.864L8.98692 20.1803ZM13.8888 19.5453C13.4792 19.6067 13.1969 19.9886 13.2583 20.3982C13.3197 20.8079 13.7015 21.0902 14.1112 21.0288L13.8888 19.5453ZM4.38275 9.0177C5.01642 8.65555 5.64023 8.87817 5.85429 9.24524L7.15007 8.48962C6.4342 7.26202 4.82698 7.03613 3.63846 7.71539L4.38275 9.0177ZM3.63846 7.71539C2.44761 8.39597 1.83532 9.8969 2.55491 11.1309L3.85068 10.3753C3.64035 10.0146 3.75139 9.37853 4.38275 9.0177L3.63846 7.71539ZM7.04896 3.75034L7.89085 5.19405L9.18662 4.43843L8.34474 2.99472L7.04896 3.75034ZM7.89085 5.19405L10.4165 9.52517L11.7123 8.76955L9.18662 4.43843L7.89085 5.19405ZM8.83384 11.377L7.15007 8.48962L5.85429 9.24524L7.53806 12.1327L8.83384 11.377ZM7.15007 8.48962L5.04535 4.88036L3.74958 5.63598L5.85429 9.24524L7.15007 8.48962ZM5.57742 3.5228C6.21109 3.16065 6.8349 3.38327 7.04896 3.75034L8.34474 2.99472C7.62887 1.76712 6.02165 1.54123 4.83313 2.22048L5.57742 3.5228ZM4.83313 2.22048C3.64228 2.90107 3.02999 4.40199 3.74958 5.63598L5.04535 4.88036C4.83502 4.51967 4.94606 3.88363 5.57742 3.5228L4.83313 2.22048ZM11.1902 3.30841L13.7159 7.63953L15.0117 6.88391L12.486 2.55279L11.1902 3.30841ZM13.7159 7.63953L15.3997 10.5269L16.6954 9.77132L15.0117 6.88391L13.7159 7.63953ZM9.71869 3.08087C10.3524 2.71872 10.9762 2.94134 11.1902 3.30841L12.486 2.55279C11.7701 1.32519 10.1629 1.0993 8.9744 1.77855L9.71869 3.08087ZM8.9744 1.77855C7.78355 2.45914 7.17126 3.96006 7.89085 5.19405L9.18662 4.43843C8.97629 4.07774 9.08733 3.4417 9.71869 3.08087L8.9744 1.77855ZM15.5437 5.52635C16.1774 5.1642 16.8012 5.38682 17.0153 5.75389L18.311 4.99827C17.5952 3.77068 15.988 3.54478 14.7994 4.22404L15.5437 5.52635ZM14.7994 4.22404C13.6086 4.90462 12.9963 6.40555 13.7159 7.63953L15.0117 6.88391C14.8013 6.52322 14.9124 5.88718 15.5437 5.52635L14.7994 4.22404ZM2.55491 11.1309L6.34339 17.6276L7.63917 16.8719L3.85068 10.3753L2.55491 11.1309ZM19.5409 10.085C21.1461 12.8377 19.9501 16.6792 16.5854 18.6021L17.3297 19.9045C21.2539 17.6618 22.9512 12.9554 20.8367 9.32939L19.5409 10.085ZM15.0798 14.5444C14.4045 13.3863 14.8772 11.6818 16.4197 10.8003L15.6754 9.49797C13.5735 10.6993 12.5995 13.2687 13.784 15.3L15.0798 14.5444ZM19.0512 9.24524L19.5409 10.085L20.8367 9.32939L20.347 8.48962L19.0512 9.24524ZM9.70616 18.864C8.85353 18.3981 8.13826 17.7278 7.63917 16.8719L6.34339 17.6276C6.98843 18.7337 7.90969 19.5917 8.98692 20.1803L9.70616 18.864ZM16.5854 18.6021C15.7158 19.0991 14.7983 19.409 13.8888 19.5453L14.1112 21.0288C15.2038 20.865 16.2984 20.4939 17.3297 19.9045L16.5854 18.6021Z" fill="currentColor"></path>
                            </g>
                        </svg>
                        <?= Html::encode(implode(', ', $model->getOptionLabels('format', 'format'))) ?>
                    </p>
                    <p>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_icurrentColoronCarrier">
                                <path d="M5.875 12.5729C5.30847 11.2498 5 9.84107 5 8.51463C5 4.9167 8.13401 2 12 2C15.866 2 19 4.9167 19 8.51463C19 12.0844 16.7658 16.2499 13.2801 17.7396C12.4675 18.0868 11.5325 18.0868 10.7199 17.7396C9.60664 17.2638 8.62102 16.5151 7.79508 15.6" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                <path d="M14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z" stroke="currentColor" stroke-width="1.5"></path>
                                <path d="M20.9605 15.5C21.6259 16.1025 22 16.7816 22 17.5C22 18.4251 21.3797 19.285 20.3161 20M3.03947 15.5C2.37412 16.1025 2 16.7816 2 17.5C2 19.9853 6.47715 22 12 22C13.6529 22 15.2122 21.8195 16.5858 21.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                            </g>
                        </svg>
                        <?= Html::encode($model->getOptionLabel('city', 'city')) .' '. Html::encode($model->address) ?? ''?>
                    </p>

                </div>
                <div class="col-md-7">
                    <p>
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_icurrentColoronCarrier">
                                <path d="M8 10.5H16" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                <path d="M8 14H13.5" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                                <path d="M17 3.33782C15.5291 2.48697 13.8214 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22C17.5228 22 22 17.5228 22 12C22 10.1786 21.513 8.47087 20.6622 7" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                            </g>
                        </svg>
                        <?= Html::encode(implode(', ', $model->getOptionLabels('language', 'language'))) ?>
                    </p>
                    <p><strong><?= Yii::t('specialist', 'Experience') ?>:</strong> <?= $model->experience ?></p>

                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-4">
                    <h4><?= Yii::t('specialist', 'Type of therapy') ?></h4>
                </div>
                <div class="col-md-4">
                    <h4><?= Yii::t('specialist', 'Theme') ?>:</h4>
                </div>
                <div class="col-md-4">
                    <h4><?= Yii::t('specialist', 'Approach') ?>:</h4>
                </div>
                <hr class="border border-success border-2 opacity-75">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php
                    $therapyTypes = $model->getOptionLabels('therapy_types', 'therapy_types');
                    if (!empty($therapyTypes)) {
                        foreach ($therapyTypes as $type) {
                            echo '<p>' . Html::encode($type) . '</p>';
                            echo '<hr class="border border-success border-1 opacity-75">';
                        }
                    } else {
                        echo '—';
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    $themes = $model->getOptionLabels('theme', 'theme');
                    if (!empty($themes)) {
                        foreach ($themes as $theme) {
                            echo '<p>' . Html::encode($theme) . '</p>';
                            echo '<hr class="border border-success border-1 opacity-75">';
                        }
                    } else {
                        echo '—';
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                    $approachTypes = $model->getOptionLabels('approach_type', 'approach_type');
                    if (!empty($approachTypes)) {
                        foreach ($approachTypes as $approachType) {
                            echo '<p>' . Html::encode($approachType) . '</p>';
                            echo '<hr class="border border-success border-1 opacity-75">';
                        }
                    } else {
                        echo '—';
                    }
                    ?>
                </div>
            </div>
            <hr class="border border-success border-2 opacity-75">

            <div class="row justify-content-center">
                <?php if ($model->lgbt): ?>
                    <div class="col-md-5 text-center">

                        <svg width="50" height="50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
                            <g id="Elements">
                                <g id="XMLID_131_">
                                    <path id="XMLID_217_" style="fill:#7416A8;" d="M249.999,407.707c0,0,33.944-19.895,72.889-50.471H177.111
                                        C216.056,387.812,249.999,407.707,249.999,407.707z" />
                                    <path id="XMLID_218_" style="fill:#2C5EFB;" d="M177.111,357.236h145.777c19.764-15.517,40.814-33.785,59.372-53.602H117.74
                                        C136.298,323.451,157.347,341.718,177.111,357.236z" />
                                    <path id="XMLID_219_" style="fill:#2FAD4C;" d="M117.74,303.634h264.52c15.904-16.983,29.976-35.102,39.835-53.602H77.905
                                        C87.764,268.532,101.836,286.651,117.74,303.634z" />
                                    <path id="XMLID_220_" style="fill:#FCE22B;" d="M64.774,214.248c2.235,11.951,6.821,23.946,13.131,35.784h344.19
                                        c6.31-11.839,10.895-23.833,13.13-35.784c1.138-6.082,1.904-12.027,2.305-17.817H62.47
                                        C62.87,202.221,63.636,208.166,64.774,214.248z" />
                                    <path id="XMLID_221_" style="fill:#F87316;" d="M62.47,196.431H437.53c1.388-20.056-1.674-38.229-9.404-53.601H71.873
                                        C64.144,158.202,61.082,176.375,62.47,196.431z" />
                                    <path id="XMLID_222_" style="fill:#F7022D;" d="M349.472,93.511c-70.66-10.291-99.473,47.988-99.473,47.988
                                        s-28.812-58.279-99.472-47.988c-39.869,5.806-65.755,23.665-78.654,49.318h356.253C415.228,117.176,389.342,99.317,349.472,93.511
                                        z" />
                                </g>
                            </g>
                        </svg>
                        <p>
                            <?= Yii::t('specialist', 'LGBTQ+ friendly') ?>
                        </p>

                    </div>
                <?php endif; ?>
                <?php if ($model->military): ?>
                    <div class="col-md-5 text-center">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracurrentColorerCarrier" stroke-linecurrentcap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_icurrentColoronCarrier">
                                <path d="M10.8613 8.36335C11.3679 7.45445 11.6213 7 12 7C12.3787 7 12.6321 7.45445 13.1387 8.36335L13.2698 8.59849C13.4138 8.85677 13.4858 8.98591 13.598 9.07112C13.7103 9.15633 13.8501 9.18796 14.1296 9.25122L14.3842 9.30881C15.3681 9.53142 15.86 9.64273 15.977 10.0191C16.0941 10.3955 15.7587 10.7876 15.088 11.572L14.9144 11.7749C14.7238 11.9978 14.6285 12.1092 14.5857 12.2471C14.5428 12.385 14.5572 12.5336 14.586 12.831L14.6122 13.1018C14.7136 14.1482 14.7644 14.6715 14.4579 14.9041C14.1515 15.1367 13.6909 14.9246 12.7697 14.5005L12.5314 14.3907C12.2696 14.2702 12.1387 14.2099 12 14.2099C11.8613 14.2099 11.7304 14.2702 11.4686 14.3907L11.2303 14.5005C10.3091 14.9246 9.84847 15.1367 9.54206 14.9041C9.23565 14.6715 9.28635 14.1482 9.38776 13.1018L9.41399 12.831C9.44281 12.5336 9.45722 12.385 9.41435 12.2471C9.37147 12.1092 9.27617 11.9978 9.08557 11.7749L8.91204 11.572C8.2413 10.7876 7.90593 10.3955 8.02297 10.0191C8.14001 9.64273 8.63194 9.53142 9.61581 9.30881L9.87035 9.25122C10.1499 9.18796 10.2897 9.15633 10.402 9.07112C10.5142 8.98591 10.5862 8.85677 10.7302 8.59849L10.8613 8.36335Z" stroke="currentColor" stroke-width="1.5"></path>
                                <path d="M3 10.4167C3 7.21907 3 5.62028 3.37752 5.08241C3.75503 4.54454 5.25832 4.02996 8.26491 3.00079L8.83772 2.80472C10.405 2.26824 11.1886 2 12 2C12.8114 2 13.595 2.26824 15.1623 2.80472L15.7351 3.00079C18.7417 4.02996 20.245 4.54454 20.6225 5.08241C21 5.62028 21 7.21907 21 10.4167C21 10.8996 21 11.4234 21 11.9914C21 14.4963 20.1632 16.4284 19 17.9041M3.19284 14C4.05026 18.2984 7.57641 20.5129 9.89856 21.5273C10.62 21.8424 10.9807 22 12 22C13.0193 22 13.38 21.8424 14.1014 21.5273C14.6796 21.2747 15.3324 20.9478 16 20.5328" stroke="currentColor" stroke-width="1.5" stroke-linecurrentcap="round"></path>
                            </g>
                        </svg>
                        <p> <?= Yii::t('specialist', 'Work with military personnel') ?></p>
                    </div>
                <?php endif; ?>

            </div>
            <hr class="border border-success border-2 opacity-75">

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h3><?= Yii::t('profile', 'Profile education and additional certifications') ?></h3>



                    <h4><?= Yii::t('profile', 'Profile education') ?>:</h4>
                    <p><?= Html::encode($model->education_name) ?></p>
                    <p><?= Yii::t('profile', 'Profile education file') ?>:

                        <?php if ($model->education_file): ?>
                            <a href="<?= Url::to(['download-education', 'id' => $model->id]) ?>" class="btn btn-outline-primary">
                                <?= Yii::t('profile', 'Download') ?>
                            </a>
                        <?php else: ?>
                    </p>
                    <p><?= Yii::t('profile', 'Profile education empty') ?></p>
                <?php endif; ?>

                <?php if ($model->additional_certification && $model->additional_certification_file): ?>

                    <h4><?= Yii::t('profile', 'Profile additional_certification') ?>:</h4>
                    <p><?= Html::encode($model->additional_certification) ?>
                        <?php if ($model->additional_certification_file): ?>
                    <p><?= Yii::t('profile', 'Profile additional_certification file') ?>:</p>
                    <a href="<?= Url::to(['download-additional-certification', 'id' => $model->id]) ?>" class="btn btn-outline-primary">
                        <?= Yii::t('profile', 'Download') ?>
                    </a>
                <?php endif; ?>
                </p>
            <?php endif; ?>
            </table>
                </div>
            </div>
        </div>

        <hr>
        <div>
            <h2><?= Yii::t('specialist', 'Book session') ?></h2>

            <div class="row justify-content-center">
                <?php if ($specialistSchedules): ?>
                    <?php foreach ($specialistSchedules as $schedule): ?>
                        <?php
                        $isFree = !$schedule->isBooked();
                        $isNotCanceled = ($schedule->status !== $schedule::STATUS_CANCELED);
                        $cardContent = Html::tag(
                            'p',
                            $isFree
                                ? '<span class="badge rounded-pill bg-warning float-end">' . Yii::t('specialist', 'Free') . '</span>'
                                : '<span class="badge rounded-pill bg-success text-bg-success float-end">' . Yii::t('specialist', 'Booked') . '</span>',
                            ['class' => 'mb-1']
                        );
                        $cardContent .= Html::tag(
                            'div',
                            '<p>' . Yii::$app->formatter->asDatetime($schedule->datetime, 'l, d/M/Y') . '</p>' .
                                '<p>' . Yii::$app->formatter->asDatetime($schedule->datetime, 'H:i') . ' - ' . $schedule->getEndTime() . '</p>' .
                                '<p class="badge rounded-pill bg-primary mb-0">' . $schedule->duration . ' ' . Yii::t('specialist', 'min') . '</p>',
                        );
                        ?>
                        <?php if ($isNotCanceled): ?>
                            <div class="col-md-2 col-lg-2 text-center mx-1 py-1 px-3">

                                <?php if ($isFree): ?>
                                    <?= Html::a(
                                        $cardContent,
                                        ['specialist/book-session', 'sessionId' => $schedule->id],
                                        ['class' => 'alert alert-primary text-decoration-none text-reset d-block']
                                    ) ?>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <?= $cardContent ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p><?= Yii::t('specialist', 'No free sessions') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <div>
            <h2><?= Yii::t('specialist', 'Reviews') ?></h2>
            <?php if ($reviews): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="card-title">
                                <strong>
                                    <?= $review->client->name ?>
                                </strong>
                                <span>
                                    <small class="text-muted"><?= Yii::$app->formatter->asDatetime($review->date, 'd/M/Y') ?></small>
                                </span>
                            </p>
                            <hr>
                            <p>
                                <?= str_repeat('⭐', $review->rating) ?> </p>
                            <blockquote class="blockquote">
                                <p><?= $review->comment ?? '' ?></p>
                            </blockquote>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="alert alert-warning"><?= Yii::t('specialist', 'No reviews yet') ?></p>
            <?php endif; ?>
        </div>
        <?php if ($canLeaveReview): ?>
            <hr>
            <div class="row">
                <h2><?= Yii::t('specialist', 'Rate specialist') ?></h2>
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($newReview, 'rating')->dropDownList([
                    5 => '⭐⭐⭐⭐⭐',
                    4 => '⭐⭐⭐⭐',
                    3 => '⭐⭐⭐',
                    2 => '⭐⭐',
                    1 => '⭐',
                ], ['prompt' => 'Оберіть рейтинг']) ?>
                <div class="d-none">
                    <?= $form->field($newReview, 'doctor_id')->textInput(['value' => $model->id]) ?>
                </div>
                <?= $form->field($newReview, 'comment')->textarea(['rows' => 3]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('specialist', 'Rate'), ['class' => 'btn btn-primary']) ?>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>