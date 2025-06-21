<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\services\PhotoService;
use app\models\SpecialistApplication;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>


<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" href="<?= Yii::getAlias('@web/css/site.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/zoicd24dcfgq6woaxwh06rzccp4u6az5cmtxma9sk7ytmpab/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body class="d-flex flex-column vh-100">
    <?php $this->beginBody() ?>

    <div class="navbar-bg fixed-top">

        <!-- Long mobile nav svg -->
        <div class="svg-wrapper long-mob-nav d-none d-md-none">
            <?= file_get_contents(Yii::getAlias('@webroot/svg/long-mob-nav.svg')) ?>
        </div>

        <!-- Small mobile nav svg -->
        <div class="svg-wrapper mob-nav d-block d-md-none">
            <?= file_get_contents(Yii::getAlias('@webroot/svg/small-mob-nav.svg')) ?>
        </div>

        <!-- Large nav svg -->
        <div class="svg-wrapper desktop-nav d-none d-md-block">
            <?= file_get_contents(Yii::getAlias('@webroot/svg/desktop-nav.svg')) ?>
        </div>

    </div>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => file_get_contents(Yii::getAlias('@webroot/svg/logo.svg')),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar',
            ],
            'innerContainerOptions' => ['class' => 'container'],
        ]);


        echo Html::beginTag('div', ['class' => 'navbar-nav d-flex justify-content-between align-items-md-center w-100 flex-nowrap']);

        // Центр
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav flex-md-grow-1 justify-content-center'],
            'items' => [
                ['label' => Yii::t('app', 'Our specialists'), 'url' => ['/site/specialists'], 'options' => ['class' => 'px-3']],
                ['label' => Yii::t('app', 'For therapists'), 'url' => ['/site/for-therapists'], 'options' => ['class' => 'px-3']],
                ['label' => Yii::t('app', 'Blog'), 'url' => ['/article'], 'options' => ['class' => 'px-3']],
                ['label' => Yii::t('app', 'About'), 'url' => ['/site/about'], 'options' => ['class' => 'px-3']],
            ],
        ]);

        // Правий блок
        $menuItems = [];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' =>
                Html::img(
                    PhotoService::checkImageUrl(Yii::$app->user->identity->photo_url ?? ''),
                    [
                        'class' => 'img-fluid rounded-circle',
                        'alt' => Yii::$app->user->identity->name,
                        'style' => 'width: 30px; height: 30px; margin-left: 8px;',
                    ]
                ),
                'encode' => false,
                'items' => array_filter([
                    (Yii::$app->user->identity->isSpecialist() || SpecialistApplication::getByUserId(Yii::$app->user->identity->id))
                        ? ['label' => Yii::t('profile', 'Profile title'), 'url' => ['/specialist/profile']]
                        : ['label' => Yii::t('profile', 'Profile title'), 'url' => ['/site/profile']],

                    Yii::$app->user->identity->isAdmin()
                        ? ['label' => Yii::t('app', 'Admin Panel'), 'url' => ['/admin/'], 'options' => ['class' => 'px-3']]
                        : null,
                    [
                        'label' => Yii::t('app', 'Logout') . ' ' . Html::tag(
                            'span',
                            '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                            </svg>',
                            ['class' => 'ms-1']
                        ),
                        'encode' => false,
                        'url' => ['/site/logout'],
                        'linkOptions' => [
                            'data-method' => 'post',
                            'class' => 'nav-link text-danger ps-3',
                        ],
                    ],
                ]),
            ];
        }

        // Мовне меню
        $menuItems[] = [
            'label' => Html::tag(
                'span',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
            <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
        </svg>',
                ['class' => 'ms-1']
            ),
            'encode' => false,
            'items' => [
                ['label' => 'Українська', 'url' => ['/site/set-language', 'lang' => 'uk']],
                ['label' => 'English', 'url' => ['/site/set-language', 'lang' => 'en']],
            ],
        ];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav d-flex align-content-sm-start px-3'],
            'items' => $menuItems,
        ]);


        echo Html::endTag('div'); // collapse
        NavBar::end();


        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container vh-90">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'], 'options' => ['class' => 'mt-5']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto">

        <div class="container-fluid mx-0 px-0 position-relative">

            <!-- Small footer svg -->
            <div class="svg-wrapper d-sm-block d-md-none">
                <?= file_get_contents(Yii::getAlias('@webroot/svg/small-footer.svg')) ?>
            </div>

            <!-- Large footer svg -->
            <div class="svg-wrapper d-none d-md-block d-lg-block">
                <?= file_get_contents(Yii::getAlias('@webroot/svg/large-footer.svg')) ?>
            </div>


        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const collapse = document.querySelector('.navbar-collapse');
        const longMobileSvg = document.querySelector('.long-mob-nav');
        const mobileSvg = document.querySelector('.mob-nav');

        if (collapse && longMobileSvg && mobileSvg) {
            collapse.addEventListener('show.bs.collapse', () => {
                longMobileSvg.classList.remove('d-none');
                mobileSvg.classList.add('d-none');
            });

            collapse.addEventListener('hide.bs.collapse', () => {
                longMobileSvg.classList.add('d-none');
                mobileSvg.classList.remove('d-none');
            });
        }
    });
</script>


</html>
<?php $this->endPage() ?>