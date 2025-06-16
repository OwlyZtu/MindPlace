<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

use app\models\User;

use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use app\models\forms\ContactForm;
use app\models\forms\UserSettingsForm;
use app\models\forms\QuestionnaireForm;
use app\models\forms\FilterForm;
use app\models\forms\UserProfileForm;

use app\models\forms\therapistJoin\TherapistJoinForm;
use app\models\forms\therapistJoin\TherapistPersonalInfoForm;
use app\models\forms\therapistJoin\TherapistEducationForm;
use app\models\forms\therapistJoin\TherapistDocumentsForm;
use app\models\forms\therapistJoin\TherapistApproachesForm;


use app\components\GoogleClient;

use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use app\services\UserAuthService;

class SiteController extends Controller
{
    public $enableCsrfValidation = true;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'login',
                            'signup',
                            'error',
                            'contact',
                            'about',
                            'for-therapists',
                            'questionnaire',
                            'specialists',
                            'set-language',
                            'google-callback',
                            'google-callback-success',
                            'auth-google',
                            'gmeet'
                        ],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => [
                            'load-step',
                            'save-personal-info',
                            'save-education',
                            'save-documents',
                            'save-approaches',
                            'final-submit'
                        ],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['logout', 'profile', 'specialist-profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'profile' => ['get', 'post'],
                    'for-therapists' => ['get', 'post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }

        if ($lang = Yii::$app->session->get('language')) {
            Yii::$app->language = $lang;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Sets the language for the application.
     *
     * @param string $lang The language code (e.g., 'uk', 'en').
     * @return Response
     */
    public function actionSetLanguage($lang)
    {
        if (in_array($lang, ['uk', 'en'])) {
            Yii::$app->session->set('language', $lang);
            Yii::$app->language = $lang;
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isUser()) {
            return $this->goHome();
        }

        $model = new UserSettingsForm();

        Yii::info(Yii::$app->request->post(), 'debug-post');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->userUpdateSettingsForm()) {
                Yii::$app->session->setFlash('success', 'Профіль успішно оновлено');
            } else {
                Yii::$app->session->setFlash('error', 'Помилка при оновленні профілю');
            }
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionSpecialistProfile()
    {
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isSpecialist()) {
            return $this->goHome();
        }

        $model = new UserSettingsForm();

        Yii::info(Yii::$app->request->post(), 'debug-post');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->userUpdateSettingsForm()) {
                Yii::$app->session->setFlash('success', 'Профіль успішно оновлено');
            } else {
                Yii::$app->session->setFlash('error', 'Помилка при оновленні профілю');
            }
            return $this->refresh();
        }

        return $this->render('specialist-profile', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionLoadStep($step = 'personal-info')
    {
        $model = Yii::$app->session->get('therapistJoinForm') ?? new TherapistJoinForm();
        switch ($step) {
            case 'personal-info':
                return $this->renderPartial('therapist-join/_personal_info', ['model' => $model->personalInfo]);
            case 'education':
                return $this->renderPartial('therapist-join/_education', ['model' => $model->education]);
            case 'documents':
                return $this->renderPartial('therapist-join/_documents', ['model' => $model->documents]);
            case 'approaches':
                return $this->renderPartial('therapist-join/_approaches', ['model' => $model->approaches]);
            default:
                return $this->asJson(['success' => false, 'error' => 'Invalid step']);
        }
    }

    public function actionSavePersonalInfo()
    {
        $model = new TherapistPersonalInfoForm();
        return $this->handleFormSave($model, 'therapistPersonalInfoForm');
    }

    public function actionSaveEducation()
    {
        $model = new TherapistEducationForm();
        return $this->handleFormSave($model, 'therapistEducationForm');
    }

    public function actionSaveApproaches()
    {
        $model = new TherapistApproachesForm();
        return $this->handleFormSave($model, 'therapistApproachesForm');
    }

    private function handleFormSave($model, $sessionKey)
    {
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->set($sessionKey, $model);
            return $this->asJson(['success' => true]);
        }
        return $this->asJson(['success' => false, 'errors' => $model->getErrors()]);
    }

    public function actionSaveDocuments()
    {
        $model = new TherapistDocumentsForm();
        if ($model->load(Yii::$app->request->post())) {
            $educationFile = UploadedFile::getInstance($model, 'education_file');
            $additionalFile = UploadedFile::getInstance($model, 'additional_certification_file');
            $photoFile = UploadedFile::getInstance($model, 'photo');
            if ($photoFile) {
                $photoFileName = uniqid('photo_') . '.' . $photoFile->extension;
                $photoPath = Yii::getAlias('@runtime/uploads/' . $photoFileName);
                if (!$photoFile->saveAs($photoPath)) {
                    return $this->asJson(['success' => false, 'errors' => ['photo' => ['Не вдалося зберегти фото']]]);
                }
                $model->photo = $photoPath;
            }
            if ($educationFile) {
                $educationFileName = uniqid('edu_') . '.' . $educationFile->extension;
                $educationPath = Yii::getAlias('@runtime/uploads/' . $educationFileName);
                if (!$educationFile->saveAs($educationPath)) {
                    return $this->asJson(['success' => false, 'errors' => ['education_file' => ['Не вдалося зберегти файл освіти']]]);
                }
                $model->education_file_path = $educationPath;
                $model->education_file = $educationFile;
            }

            if ($additionalFile) {
                $additionalFileName = uniqid('cert_') . '.' . $additionalFile->extension;
                $additionalPath = Yii::getAlias('@runtime/uploads/' . $additionalFileName);
                if (!$additionalFile->saveAs($additionalPath)) {
                    return $this->asJson(['success' => false, 'errors' => ['additional_certification_file' => ['Не вдалося зберегти сертифікат']]]);
                }
                $model->additional_certification_file_path = $additionalPath;
                $model->additional_certification_file = $additionalFile;
            }

            if ($model->validate()) {
                $filesData = $model->uploadToS3();
                Yii::$app->session->set('therapistDocumentsForm', $filesData);
                return $this->asJson(['success' => true]);
            } else {
                Yii::error('Validation error', 'therapist-join');
                return $this->asJson(['success' => false, 'errors' => $model->getErrors()]);
            }
        }

        return $this->asJson(['success' => false, 'errors' => ['save' => ['Некоректний запит']]]);
    }

    public function actionForTherapists($step = 'personal-info')
    {
        $model = new TherapistJoinForm();

        if (!Yii::$app->user->isGuest) {
            $this->actionLoadStep();

            $s3 = Yii::$app->get('s3Storage');
            if (!$s3->testConnection()) {
                Yii::error('S3 client not initialized properly', 'upload');
                Yii::$app->session->setFlash('error', 'Сталася внутрішня помилка. Спробуйте пізніше.');
                return $this->render('therapist-join/for-therapists', [
                    'model' => $model,
                    'step' => $step
                ]);
            }
            if ($model->load(Yii::$app->request->post())) {
                if (!$model->validate()) {
                    Yii::info('Fuck submit if false', 'therapist-join');

                    return $this->asJson([
                        'success' => false,
                        'errors' => $model->getErrors(),
                    ]);
                }
            }

            return $this->render('therapist-join/for-therapists', [
                'model' => $model,
                'step' => $step,
            ]);
        }

        return $this->render('therapist-join/for-therapists', [
            'model' => $model,
        ]);
    }

    public function actionFinalSubmit()
    {
        $model = new TherapistJoinForm();

        if (!Yii::$app->user->isGuest && Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->updateUserAsTherapist()) {
                return $this->asJson(['success' => true]);
            }

            return $this->asJson(['success' => false, 'errors' => $model->getErrors()]);
        }

        return $this->asJson(['success' => false, 'errors' => ['submit' => ['Некоректний запит або неавторизовано']]]);
    }

    /**
     * Displays questionnaire page.
     *
     * @return Response|string
     */
    public function actionQuestionnaire()
    {
        $model = new QuestionnaireForm();
        if ($model->load(Yii::$app->request->post()) && $model->questionnaire('questionnaireData')) {
            return $this->render('specialists', [
                'filter' => Yii::$app->session->get('questionnaireData'),
            ]);
        }
        return $this->render('questionnaire', [
            'model' => $model,
        ]);
    }

    public function actionSpecialists()
    {
        return $this->redirect(['specialist/index']);
    }

    public function actionAuthGoogle()
    {
        $client = GoogleClient::getClient();
        $authService = new UserAuthService($client);
    
        if ($client->getAccessToken() && !$client->isAccessTokenExpired()) {
            return $this->redirect(['site/google-callback']);
        }
        return $this->redirect($authService->getAuthUrl());
    }

    public function actionGoogleCallback()
    {
        $client = GoogleClient::getClient();
        $authService = new UserAuthService($client);
    
        $code = Yii::$app->request->get('code');
    
        if (!$code) {
            return $this->renderContent('Не передано code від Google');
        }
    
        $error = $authService->authenticateWithCode($code);
        if ($error) {
            Yii::error('Google Auth error: ' . $error, 'google-auth');
            return $this->renderContent('Помилка авторизації: ' . $error);
        }
        return $this->redirect(['site/google-callback-success']);

    }

    public function actionGoogleCallbackSuccess()
    {
        $client = GoogleClient::getClient();
        $authService = new UserAuthService($client);

        $birthDate = $authService->getUserBirthdate();
        $model = new UserProfileForm();
    
        if ($birthDate !== null && $birthDate !== '0000-00-00') {
            $model->birth_date = $birthDate;
        }
    
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $authService->loginOrCreateUser($model);
            return $this->goHome();
        }
    
        return $this->render('profile-form', [
            'model' => $model,
            'birthDateFromGoogle' => $birthDate,
        ]);
    }

    public function actionCallback()
    {
        $client = GoogleClient::getClient();

        $code = Yii::$app->request->get('code');

        if ($code) {
            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                Yii::error('Google Auth error: ' . $token['error_description'], 'google-auth');
                return $this->renderContent('Помилка авторизації: ' . $token['error_description']);
            }

            $tokenPath = Yii::getAlias('@app/runtime/google-token.json');
            file_put_contents($tokenPath, json_encode($token));
            if (file_put_contents($tokenPath, json_encode($token)) === false) {
                Yii::error('Не вдалося зберегти токен у файл: ' . $tokenPath, 'google-auth');
            }
            return $this->redirect(['site/gmeet']);
        }

        return $this->renderContent('Не передано code від Google');
    }


    public function actionGmeet()
    {
        $client = GoogleClient::getClient();
        $service = new Calendar($client);

        $event = new Event([
            'summary' => 'Зустріч у Meet',
            'start' => ['dateTime' => '2025-06-15T20:00:00+03:00'],
            'end' => ['dateTime' => '2025-06-15T21:00:00+03:00'],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);

        $event = $service->events->insert('primary', $event, ['conferenceDataVersion' => 1]);

        $meetLink = $event->getHangoutLink();

        return $this->render('gmeet', [
            'link' => $meetLink,
        ]);
    }
}
