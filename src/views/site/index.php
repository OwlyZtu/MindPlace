<?php

/** @var yii\web\View $this */

$this->title = 'MindPlace';
?>

<div class="site-index">
    <div class="body-content row row-gap-5">
        <!-- #region MainScreen -->
        <div class="row main-row align-content-center bg-main my-4">
            <div class="col-lg-7 img">
                <img src="<?= Yii::getAlias('@web') ?>/images/mainPhoto2.png" alt="MindPlace main photo"
                    class="img-fluid">
            </div>
            <div class="col-lg-4 text-center align-content-center">
                <h1 class="gradient-text">
                    <?= Yii::t('app', 'Welcome') ?>
                </h1>
                <span>
                    <?= Yii::t('app', 'Welcome span') ?>
                </span>
                <div class="d-flex justify-content-center mt-4">
                    <a href="<?= Yii::$app->urlManager->createUrl(['site/questionnaire']) ?>"
                        class="btn btn-primary btn-lg me-2">
                        <?= Yii::t('app', 'Find a Therapist') ?>
                    </a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['site/for-therapists']) ?>"
                        class="btn btn-secondary btn-lg">
                        <?= Yii::t('app', 'For Therapists') ?>
                    </a>
                </div>
            </div>
        </div>
        <!-- #endregion MainScreen -->


        <!-- #region InformationScreen -->
        <div class="row info-row align-content-center mb-3 text-center row-gap-2 gradient-text-alt">
            <div class="row justify-content-center mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                        class="bi bi-patch-question-fill" viewBox="0 0 16 16">
                        <path
                            d="M5.933.87a2.89 2.89 0 0 1 4.134 0l.622.638.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01zM7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0m1.602-2.027c.04-.534.198-.815.846-1.26.674-.475 1.05-1.09 1.05-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.7 1.7 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745.336 0 .504-.24.554-.627" />
                    </svg>
            </div>
            <div class="row justify-content-center mb-2">
                <h2 class="col-lg-6">
                    <?= Yii::t('app', 'Do you know...') ?>
                </h2>
            </div>

            <!-- What is... -->
            <div class="row justify-content-center mb-2">
                <div class="col-lg-5">
                    <h3 class="text-center">
                        <?= Yii::t('app', 'What is psychotherapy') ?>
                    </h3>
                    <p>
                        <?= Yii::t('app', 'What is psychotherapy descr') ?>
                    </p>
                </div>
            </div>

            <!-- Difference -->
            <div class="row justify-content-center  mb-2">
                <h3>
                    <?= Yii::t('app', 'Difference qa') ?>
                </h3>
            </div>
            <div class="row justify-content-evenly mb-4">
                <div class="col-lg-4">
                    <h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-clipboard-heart" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M5 1.5A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm5 0a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5z" />
                            <path
                                d="M3 1.5h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2" />
                            <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.31 8 6.982" />
                        </svg>
                        <?= Yii::t('app', 'Difference qa psychologist') ?>
                    </h4>
                    <p>
                        <?= Yii::t('app', 'Difference qa psychologist descr') ?>
                    </p>
                </div>
                <div class="col-lg-4">

                    <h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-clipboard-heart-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                            <path fill-rule="evenodd"
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zm4 5.982c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018" />
                        </svg>
                        <?= Yii::t('app', 'Difference qa psychotherapist') ?>
                    </h4>
                    <p>
                        <?= Yii::t('app', 'Difference qa psychotherapist descr') ?>
                    </p>
                </div>
            </div>

            <!-- Why it is important -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-4">
                    <h3>
                        <?= Yii::t('app', 'Why it is important') ?>
                    </h3>
                    <p>
                        <?= Yii::t('app', 'Why it is important descr') ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- #endregion InformationScreen -->


        <!-- #region HowItWorksScreen -->
        <div class="row how-it-works-row align-content-center mb-5 text-center gradient-text-alt">

            <div class="col-lg-6 justify-content-center mx-auto mb-4">
                <h2 class="text-center mb-4">
                    <?= Yii::t('app', 'How it works') ?>
                </h2>
                <p class="text-center">
                    <?= Yii::t('app', 'How it works descr') ?>
                </p>
            </div>
            <div class="col-lg-10 mx-auto">

                <!-- step 1 -->
                <div class="row justify-content-evenly mb-3">
                    <div class="col-lg-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#2C7B98"
                            class="bi bi-ui-checks" viewBox="0 0 16 16">
                            <path
                                d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                        </svg>
                    </div>
                    <div class="col-lg-4">
                        <h4>
                            <?= Yii::t('app', 'Step 1') ?>
                        </h4>
                        <p>
                            <?= Yii::t('app', 'Step 1 descr') ?>
                        </p>
                    </div>
                </div>
                <!-- divider -->
                <div class="row justify-content-center mb-5">
                    <svg width="364" height="143" viewBox="0 0 364 143" fill="#437576"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M336.667 14C336.667 21.3638 342.636 27.3333 350 27.3333C357.364 27.3333 363.333 21.3638 363.333 14C363.333 6.6362 357.364 0.666667 350 0.666667C342.636 0.666667 336.667 6.6362 336.667 14ZM0 143L25.7413 129.934L1.55512 114.174L0 143ZM350 14L347.829 12.7612C327.317 48.7137 300.522 68.6274 270.797 79.5587C240.978 90.5242 208.106 92.4905 175.407 92.3056C142.891 92.1217 110.271 89.7869 81.7783 92.3494C53.1909 94.9205 28.0159 102.453 10.4081 122.494L12.2863 124.144L14.1644 125.794C30.5199 107.178 54.1334 99.8559 82.2262 97.3293C110.413 94.7943 142.365 97.1188 175.379 97.3055C208.211 97.4912 241.828 95.5391 272.522 84.2514C303.31 72.9295 331.053 52.2552 352.171 15.2388L350 14Z"
                            fill="#41767A" />
                    </svg>
                </div>

                <!-- step 2 -->
                <div class="row justify-content-evenly mb-3">
                    <div class="col-lg-4">
                        <h4>
                            <?= Yii::t('app', 'Step 2') ?>
                        </h4>
                        <p>
                            <?= Yii::t('app', 'Step 2 descr') ?>
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#626f49"
                            class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                            <path
                                d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                        </svg>
                    </div>
                </div>
                <!-- divider -->
                <div class="row justify-content-center mb-5">
                    <svg width="364" height="143" viewBox="0 0 364 143" fill="#597157"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.666667 14C0.666667 21.3638 6.6362 27.3333 14 27.3333C21.3638 27.3333 27.3333 21.3638 27.3333 14C27.3333 6.6362 21.3638 0.666667 14 0.666667C6.6362 0.666667 0.666667 6.6362 0.666667 14ZM364 143L362.445 114.174L338.259 129.934L364 143ZM14 14L11.8285 15.2388C32.9468 52.2552 60.69 72.9295 91.4778 84.2514C122.172 95.5391 155.789 97.4912 188.621 97.3055C221.635 97.1188 253.587 94.7943 281.774 97.3293C309.867 99.8559 333.48 107.178 349.836 125.794L351.714 124.144L353.592 122.494C335.984 102.453 310.809 94.9205 282.222 92.3494C253.729 89.7869 221.109 92.1217 188.593 92.3056C155.894 92.4905 123.022 90.5242 93.2035 79.5587C63.4779 68.6274 36.6828 48.7137 16.1715 12.7612L14 14Z"
                            fill="#597157" />
                    </svg>

                </div>

                <!-- step 3 -->
                <div class="row justify-content-evenly mb-3">
                    <div class="col-lg-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#8E924C"
                            class="bi bi-calendar-week" viewBox="0 0 16 16">
                            <path
                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>
                    </div>
                    <div class="col-lg-4">
                        <h4>
                            <?= Yii::t('app', 'Step 3') ?>
                        </h4>
                        <p>
                            <?= Yii::t('app', 'Step 3 descr') ?>
                        </p>
                    </div>
                </div>
                <!-- divider -->
                <div class="row justify-content-center mb-5">
                    <svg width="364" height="143" viewBox="0 0 364 143" fill="#B1AD4E"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M336.667 14C336.667 21.3638 342.636 27.3333 350 27.3333C357.364 27.3333 363.333 21.3638 363.333 14C363.333 6.6362 357.364 0.666667 350 0.666667C342.636 0.666667 336.667 6.6362 336.667 14ZM0 143L25.7413 129.934L1.55512 114.174L0 143ZM350 14L347.829 12.7612C327.317 48.7137 300.522 68.6274 270.797 79.5587C240.978 90.5242 208.106 92.4905 175.407 92.3056C142.891 92.1217 110.271 89.7869 81.7783 92.3494C53.1909 94.9205 28.0159 102.453 10.4081 122.494L12.2863 124.144L14.1644 125.794C30.5199 107.178 54.1334 99.8559 82.2262 97.3293C110.413 94.7943 142.365 97.1188 175.379 97.3055C208.211 97.4912 241.828 95.5391 272.522 84.2514C303.31 72.9295 331.053 52.2552 352.171 15.2388L350 14Z"
                            fill="#B1AD4E" />
                    </svg>
                </div>

                <!-- step 4 -->
                <div class="row justify-content-evenly mb-3">
                    <div class="col-lg-4">
                        <h4>
                            <?= Yii::t('app', 'Step 4') ?>
                        </h4>
                        <p>
                            <?= Yii::t('app', 'Step 4 descr') ?>
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#CAC150"
                            class="bi bi-chat-heart" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2.965 12.695a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2m-.8 3.108.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125M8 5.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                        </svg>
                    </div>
                </div>
                <!-- divider -->
                <div class="row justify-content-center mb-5">
                    <svg width="364" height="143" viewBox="0 0 364 143" fill="#CAC150"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.666667 14C0.666667 21.3638 6.6362 27.3333 14 27.3333C21.3638 27.3333 27.3333 21.3638 27.3333 14C27.3333 6.6362 21.3638 0.666667 14 0.666667C6.6362 0.666667 0.666667 6.6362 0.666667 14ZM364 143L362.445 114.174L338.259 129.934L364 143ZM14 14L11.8285 15.2388C32.9468 52.2552 60.69 72.9295 91.4778 84.2514C122.172 95.5391 155.789 97.4912 188.621 97.3055C221.635 97.1188 253.587 94.7943 281.774 97.3293C309.867 99.8559 333.48 107.178 349.836 125.794L351.714 124.144L353.592 122.494C335.984 102.453 310.809 94.9205 282.222 92.3494C253.729 89.7869 221.109 92.1217 188.593 92.3056C155.894 92.4905 123.022 90.5242 93.2035 79.5587C63.4779 68.6274 36.6828 48.7137 16.1715 12.7612L14 14Z"
                            fill="#CAC150" />
                    </svg>

                </div>

                <!-- step 5 -->
                <div class="row justify-content-evenly mb-5">
                    <div class="col-lg-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#D9CD52"
                            class="bi bi-emoji-wink-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M7 6.5C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5M4.285 9.567a.5.5 0 0 0-.183.683A4.5 4.5 0 0 0 8 12.5a4.5 4.5 0 0 0 3.898-2.25.5.5 0 1 0-.866-.5A3.5 3.5 0 0 1 8 11.5a3.5 3.5 0 0 1-3.032-1.75.5.5 0 0 0-.683-.183m5.152-3.31a.5.5 0 0 0-.874.486c.33.595.958 1.007 1.687 1.007s1.356-.412 1.687-1.007a.5.5 0 0 0-.874-.486.93.93 0 0 1-.813.493.93.93 0 0 1-.813-.493" />
                        </svg>
                    </div>
                    <div class="col-lg-4">
                        <h4>
                            <?= Yii::t('app', 'Step 5') ?>
                        </h4>
                        <p>
                            <?= Yii::t('app', 'Step 5 descr') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- #endregion HowItWorksScreen -->


        <!-- #region FAQScreen -->
        <div class="row question-row align-content-center mb-5 text-center row-gap-3">
            <div class="col-lg-10 justify-content-center mx-auto">
                <h2 class="text-center mb-4">
                    <?= Yii::t('app', 'FAQ') ?>
                </h2>
                <p class="text-center">
                    <?= Yii::t('app', 'FAQ descr') ?>
                </p>
            </div>
            <div class="col-lg-10 mx-auto mb-4">
                <div class="accordion" id="accordionQA">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="heading<?= $i ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?= $i ?>" aria-expanded="false"
                                    aria-controls="collapse<?= $i ?>">
                                    <span class="accordion-text-alt">
                                        <?= Yii::t('app', "FAQ question $i") ?>
                                    </span>
                                </button>
                            </h3>
                            <div id="collapse<?= $i ?>" class="accordion-collapse collapse"
                                aria-labelledby="heading<?= $i ?>" data-bs-parent="#accordionQA">
                                <div class="accordion-body">
                                    <p>
                                        <span class="accordion-text-alt">
                                            <?= Yii::t('app', "FAQ answer $i") ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>


            <!-- ContactForm -->
            <div class="col-lg-5 mx-auto">
                <h3 class="text-center"><?= Yii::t('app', "Still have questions?") ?></h3>
                <p class="text-center"><?= Yii::t('app', "Still have questions descr") ?></p>
                <div class="d-flex justify-content-center mt-4">
                    <a href="<?= Yii::$app->urlManager->createUrl(['site/contact']) ?>"
                        class="btn btn-primary btn-lg"><?= Yii::t('app', "Contact us") ?></a>
                </div>
            </div>
        </div>
        <!-- #endregion FAQScreen -->
    </div>
</div>
</div>