<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

use app\models\SpecialistApplication;
use app\models\Schedule;
use yii\data\ActiveDataProvider;


use app\models\forms\LoginForm;
use app\models\forms\SignupForm;
use app\models\forms\ContactForm;
use app\models\forms\UserSettingsForm;
use app\models\forms\QuestionnaireForm;
use app\models\forms\FilterForm;
use app\models\forms\UserProfileForm;
use app\models\forms\FormOptions;

use app\models\forms\therapistJoin\TherapistJoinForm;
use app\models\forms\therapistJoin\TherapistPersonalInfoForm;
use app\models\forms\therapistJoin\TherapistEducationForm;
use app\models\forms\therapistJoin\TherapistApproachesForm;
use app\services\TherapistJoinService;

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
                        'actions' => [
                            'logout',
                            'profile',
                            'specialist-profile',
                            'cancel-schedule',
                            'book-session',
                            'session-details',
                            'session-cancel'
                        ],
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
                    'specialist-profile' => ['get', 'post'],
                    'specialists' => ['get', 'post'],
                    'book-session' => ['get', 'post'],
                    'questionnaire' => ['get', 'post'],
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
        if (
            Yii::$app->user->isGuest
            || !Yii::$app->user->identity->isUser()
            || SpecialistApplication::getByUserId(Yii::$app->user->identity->id)
        ) {
            return $this->goHome();
        }
        $clientId = Yii::$app->user->identity->id;
        $futureQuery  = Schedule::getSchedulesByClientId($clientId, Schedule::getFutureTimeCondition());
        $archiveQuery  = Schedule::getSchedulesByClientId($clientId, Schedule::getPastTimeCondition());
        $futureSchedulesProvider = new ActiveDataProvider([
            'query' => $futureQuery,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $archiveSchedulesProvider = new ActiveDataProvider([
            'query' => $archiveQuery,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $profile_settings_model = new UserSettingsForm();

        if (Yii::$app->request->isPost) {
            if ($profile_settings_model->load(Yii::$app->request->post()) && $profile_settings_model->userUpdateSettingsForm()) {
                Yii::$app->session->setFlash('success', 'Профіль успішно оновлено');
            } else {
                Yii::$app->session->setFlash('error', 'Помилка при оновленні профілю');
            }
            return $this->refresh();
        }

        return $this->render('profile', [
            'profile_settings_model' => $profile_settings_model,
            'futureSchedulesProvider' => $futureSchedulesProvider,
            'archiveSchedulesProvider' => $archiveSchedulesProvider,
        ]);
    }
    public function actionSessionDetails($id)
    {
        $session = Schedule::getScheduleById($id);
        if (!$session) {
            return $this->goHome();
        }
        return $this->render('session-details', [
            'session' => $session,
            'doctor' => $session->doctor,
            'user' => Yii::$app->user->identity,
            'therapyTypes' => FormOptions::getDoctorOptions($session->getTherapyTypes(), 'therapy_types'),
            'themes' => FormOptions::getDoctorOptions($session->getTheme(), 'theme'),
            'approachTypes' => FormOptions::getDoctorOptions($session->getApproachType(), 'approach_type'),
        ]);
    }

    public function actionSessionCancel($id)
    {
        $session = Schedule::getScheduleById($id);
    
        if (!$session) {
            throw new \yii\web\NotFoundHttpException('Запис не знайдено.');
        }
        
        date_default_timezone_set('Europe/Kyiv');
        $now = new \DateTime();
        $sessionTime = new \DateTime($session->datetime);
        $diff = $sessionTime->getTimestamp() - $now->getTimestamp();
    
        if ($diff <= 3600) {
            Yii::$app->session->setFlash('error', 'Відмінити запис неможливо, бо до сесії залишилась година або менше.');
            return $this->redirect(['site/session-details', 'id' => $id]);
        }
    
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
    
            try {
                // 1. cansel session
                $session->status = Schedule::STATUS_CANCELED;
                if (!$session->save(false, ['status'])) {
                    throw new \Exception('Не вдалося оновити статус.');
                }
    
                // 2. add copy of session
                $newSession = new Schedule();
                $newSession->load([
                    'doctor_id' => $session->doctor_id,
                    'datetime' => $session->datetime,
                    'duration' => $session->duration,
                    'status' => Schedule::STATUS_SCHEDULED,
                    'client_id' => null,
                    'meet_url' => null,
                    'details' => [],
                ], '');
    
                if (!$newSession->save()) {
                    throw new \Exception('Не вдалося створити новий запис.');
                }
    
                $transaction->commit();
    
                Yii::$app->session->setFlash('success', 'Запис скасовано. Час знову доступний для запису.');
                return $this->redirect(['site/profile']);
    
            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::error('Помилка при скасуванні запису: ' . $e->getMessage(), 'session');
                Yii::$app->session->setFlash('error', 'Не вдалося скасувати запис.');
            }
        }
    
        return $this->render('session-cancel', ['session' => $session]);
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

    // Therapist Join Actions
    private $therapistJoinService;

    public function __construct($id, $module, TherapistJoinService $therapistJoinService, $config = [])
    {
        $this->therapistJoinService = $therapistJoinService;
        parent::__construct($id, $module, $config);
    }

    public function actionLoadStep($step = 'personal-info')
    {
        try {
            $result = $this->therapistJoinService->loadStep($step);
            return $this->renderPartial($result['view'], ['model' => $result['model']]);
        } catch (\InvalidArgumentException $e) {
            return $this->asJson(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function actionSavePersonalInfo()
    {
        $model = new TherapistPersonalInfoForm();
        $result = $this->therapistJoinService->saveForm($model, 'therapistPersonalInfoForm', Yii::$app->request->post());
        return $this->asJson($result);
    }

    public function actionSaveEducation()
    {
        $model = new TherapistEducationForm();
        $result = $this->therapistJoinService->saveForm($model, 'therapistEducationForm', Yii::$app->request->post());
        return $this->asJson($result);
    }

    public function actionSaveApproaches()
    {
        $model = new TherapistApproachesForm();
        $result = $this->therapistJoinService->saveForm($model, 'therapistApproachesForm', Yii::$app->request->post());
        return $this->asJson($result);
    }

    public function actionSaveDocuments()
    {
        $postData = Yii::$app->request->post();
        $result = $this->therapistJoinService->saveDocuments($postData);
        return $this->asJson($result);
    }

    public function actionFinalSubmit()
    {
        $result = $this->therapistJoinService->finalSubmit(Yii::$app->request->post());
        return $this->asJson($result);
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

        // calendar
        $action = Yii::$app->session->get('calendar_action');
        $scheduleId = Yii::$app->session->get('calendar_schedule_id');
    
        if ($action === 'add_client_event' && $scheduleId) {
            Yii::$app->session->remove('calendar_action');
            Yii::$app->session->remove('calendar_schedule_id');
    
            return $this->redirect(['specialist/add-event-to-calendar', 'id' => $scheduleId]);
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

}
