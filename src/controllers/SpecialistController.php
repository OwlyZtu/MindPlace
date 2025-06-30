<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

use app\models\User;
use app\models\Schedule;
use app\models\Review;
use app\models\SpecialistApplication;

use app\models\forms\FilterForm;
use app\models\forms\ReviewForm;
use app\models\forms\UserSettingsForm;
use app\models\forms\SessionBookingForm;
use app\models\forms\FormOptions;
use Google\Service\Dataproc\Session;

use Google\Service\Calendar;
use Google\Service\Calendar\Event;

use app\components\GoogleClient;

class SpecialistController extends Controller
{
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
     * Sets the language for the application.
     *
     * @param string $lang The language code (e.g., 'uk', 'en').
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
     * Displays specialists page with optional filtering.
     */
    public function actionIndex()
    {
        $model = new FilterForm();

        if (Yii::$app->request->get('clear')) {
            Yii::$app->session->remove('filterData');
            return $this->redirect(['index']);
        }

        $filterData = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->saveFilterToSession()) {
                $filterData = FilterForm::getSessionFilter();
            }
        } else {
            $filterData = FilterForm::getSessionFilter();
            if ($filterData) {
                $model->setAttributes($filterData);
            } else {
                $filterData = ['role' => 'specialist'];
            }
        }

        $query = User::find()->where(['role' => 'specialist']);

        // Фільтрація
        if (!empty($filterData['format'])) {
            $query->andFilterWhere(['or like', 'format', $filterData['format']]);

            if ($filterData['format'] !== 'online') {
                $query->andWhere(['city' => $filterData['city']]);
            }
        }


        foreach (['therapy_types', 'theme', 'approach_type', 'language', 'specialization'] as $field) {
            if (!empty($filterData[$field])) {
                $query->andFilterWhere(['or like', $field, $filterData[$field]]);
            }
        }

        if (!empty($filterData['gender'])) {
            $query->andWhere(['gender' => $filterData['gender']]);
        }

        if (!empty($filterData['age'])) {
            $ageRange = $model->getAgeRange($filterData['age']);
            if ($ageRange) {
                $query->andWhere(['between', 'birth_date', $ageRange['from'], $ageRange['to']]);
            }
        }

        if (isset($filterData['lgbt']) && $filterData['lgbt']) {
            $query->andWhere(['lgbt' => 1]);
        }

        if (isset($filterData['military']) && $filterData['military']) {
            $query->andWhere(['military' => 1]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 9],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        return $this->render('index', [
            'model' => $model,
            'filter' => $filterData,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * View single specialist profile
     * @param int $id
     * @return string|yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $specialist = User::findOne(['id' => $id, 'role' => 'specialist']);
        if (!$specialist) {
            throw new NotFoundHttpException("Спеціаліста не знайдено.");
        }

        $specialistSchedules = Schedule::getSchedulesByDoctorId($specialist->id, Schedule::getFutureTimeCondition())->all();
        $reviews = Review::getReviewsByDoctorId($specialist->id);
        $avgRating = Review::getAverageRating($specialist->id);
        if (Yii::$app->user->isGuest || $specialist->id === Yii::$app->user->identity->id) {
            $canLeaveReview = false;
        } else {
            $canLeaveReview = Schedule::ifCanLeaveReview(Yii::$app->user->identity->id, $specialist->id);
        }

        $newReview = new ReviewForm();

        if ($newReview->load(Yii::$app->request->post()) && $newReview->validate()) {
            if ($newReview->save()) {
                Yii::$app->session->setFlash('success', 'Відгук успішно додано.');
                return $this->refresh();
            } else {
                Yii::error('Review save errors: ' . print_r($newReview->getErrors(), true), 'review-save');
                Yii::$app->session->setFlash('error', 'Помилка при додаванні відгуку.');
            }
        }
        return $this->render('view', [
            'model' => $specialist,
            'reviews' => $reviews,
            'avgRating' => $avgRating,
            'newReview' => $newReview,
            'specialistSchedules' => $specialistSchedules,
            'canLeaveReview' => $canLeaveReview,
        ]);
    }

    public function actionBookSession($sessionId)
    {
        $schedule = Schedule::getScheduleById($sessionId);
        if (!$schedule || !$schedule->doctor) {
            throw new NotFoundHttpException('Час недоступний або вже заброньований.');
        }
        $model = new SessionBookingForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->book($schedule)) {
                Yii::$app->session->setFlash('success', 'Ви успішно записались на консультацію.');
                if ($model->add_to_google_calendar) {
                    $model->addToCalendar($schedule->doctor->id, $schedule->datetime, $schedule->duration);
                }
                $model->addToCalendarForDoctor($schedule->doctor->id, $schedule->datetime, $schedule->duration);
                return $this->redirect(['site/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Помилка при записі на сесію.');
                Yii::error('Session booking errors: ' . print_r($model->getErrors(), true), 'session-book');
            }
        }

        return $this->render('book-session', [
            'model' => $model,
            'schedule' => $schedule,
            'doctor' => $schedule->doctor,
            'user' => Yii::$app->user->identity,
        ]);
    }

    public function actionAddEventToCalendar($id)
    {
        $schedule = Schedule::findOne($id);
        if (!$schedule) {
            throw new NotFoundHttpException("Розклад не знайдено.");
        }

        SessionBookingForm::addToCalendar($schedule->doctor->id, $schedule->datetime, $schedule->duration);
        SessionBookingForm::addToCalendarForDoctor($schedule->doctor->id, $schedule->datetime, $schedule->duration);

        Yii::$app->session->setFlash('success', 'Подію додано до Google Calendar.');
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionProfile()
    {
        if (
            Yii::$app->user->isGuest
            || (!Yii::$app->user->identity->isSpecialist()
                && !SpecialistApplication::getByUserId(Yii::$app->user->identity->id))
        ) {
            Yii::info('User is not a specialist', 'profile');
            return $this->goHome();
        }

        $doctorId = Yii::$app->user->identity->id;

        $showOnlyBusy = Yii::$app->request->get('busy_only') == true;

        $futureQuery  = Schedule::getSchedulesByDoctorId($doctorId, Schedule::getFutureTimeCondition(), $showOnlyBusy);
        $archiveQuery  = Schedule::getSchedulesByDoctorId($doctorId, Schedule::getPastTimeCondition());
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
        $schedule_model = new Schedule();
        $schedule_model->doctor_id = $doctorId;

        if (Yii::$app->request->isPost) {
            $formName = Yii::$app->request->post('form_name');

            if ($formName === 'update-profile') {
                if ($profile_settings_model->load(Yii::$app->request->post()) && $profile_settings_model->userUpdateSettingsForm()) {
                    Yii::$app->session->setFlash('success', 'Профіль успішно оновлено');
                } else {
                    Yii::$app->session->setFlash('error', 'Помилка при оновленні профілю');
                }
                return $this->refresh();
            }

            if ($formName === 'create-schedule') {
                $schedule_model = new Schedule();
                if ($schedule_model->load(Yii::$app->request->post())) {
                    if ($schedule_model->save()) {
                        Yii::$app->session->setFlash('success', 'Графік додано');
                    } else {
                        Yii::$app->session->setFlash('error', 'Сталася помилка при створенні графіку');
                        Yii::info('Schedule model errors: ' . print_r($schedule_model->getErrors(), true), 'schedule');
                    }
                    return $this->refresh();
                }
            }
        }

        return $this->render('profile', [
            'profile_settings_model' => $profile_settings_model,
            'futureSchedulesProvider' => $futureSchedulesProvider,
            'archiveSchedulesProvider' => $archiveSchedulesProvider,
            'schedule_model' => $schedule_model,
            'application_status' => SpecialistApplication::getStatusById($doctorId) ?? 'pending',
            'busyOnly' => $showOnlyBusy,
        ]);
    }

    public function actionCancelSchedule($id)
    {
        $schedule = Schedule::getScheduleById($id);

        if (!$schedule) {
            throw new NotFoundHttpException('Запис розкладу не знайдено.');
        }

        if ($schedule->doctor_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('Ви не маєте прав на видалення цього запису.');
        }

        if ($schedule->isBooked()) {
            Yii::$app->session->setFlash('error', 'Неможливо видалити запис, оскільки призначено сесію.');
            return $this->redirect(['specialist/profile']);
        }

        if ($schedule->delete() !== false) {
            Yii::$app->session->setFlash('success', 'Запис розкладу успішно видалено.');
        } else {
            Yii::$app->session->setFlash('error', 'Помилка при видаленні запису розкладу.');
        }

        return $this->redirect(['specialist/profile']);
    }

    public function actionSessionDetails($id)
    {
        $session = Schedule::getScheduleById($id);
        if (!$session) {
            return $this->goHome();
        }
        $timezone = new \DateTimeZone(Yii::$app->timeZone);

        $now = new \DateTime('now', $timezone);
        $sessionStart = new \DateTime($session->datetime, $timezone);
        $sessionEnd = (clone $sessionStart)->add(new \DateInterval('PT' . $session->duration . 'M'));

        $diff = $sessionStart->getTimestamp() - $now->getTimestamp();
        $ifEnded = $now->getTimestamp() - $sessionEnd->getTimestamp();

        $sessionTimeFormatted = [
            'start' => $sessionStart->format('l, d M Y, H:i'),
            'end' => $sessionEnd->format('H:i'),
        ];

        $timeToLink = false;
        if ($diff <= 3600 && $ifEnded <= 0) {
            $timeToLink = true;
        }
        return $this->render('session-details', [
            'session' => $session,
            'sessionTimeFormatted' => $sessionTimeFormatted,
            'doctor' => Yii::$app->user->identity,
            'user' => $session->client,
            'therapyTypes' => FormOptions::getDoctorOptions($session->getTherapyTypes(), 'therapy_types'),
            'themes' => FormOptions::getDoctorOptions($session->getTheme(), 'theme'),
            'approachTypes' => FormOptions::getDoctorOptions($session->getApproachType(), 'approach_type'),
            'timeToLink' => $timeToLink,
        ]);
    }

    public function actionGmeet($id)
    {
        $session = Schedule::findOne($id);
        if (!$session) {
            throw new NotFoundHttpException("Сесію не знайдено.");
        }

        $client = GoogleClient::getClient();
        if ($client->isAccessTokenExpired()) {
            Yii::$app->session->setFlash('warning', 'Токен Google протермінований. Будь ласка, увійдіть знову.');
            return $this->redirect(['site/auth-google']);
        }

        $service = new Calendar($client);

        $event = new Event([
            'summary' => 'Онлайн сесія в Google Meet',
            'start' => ['dateTime' => date(DATE_RFC3339, strtotime($session->datetime))],
            'end' => ['dateTime' => date(DATE_RFC3339, strtotime($session->datetime) + intval($session->duration) * 60)],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);

        try {
            $event = $service->events->insert('primary', $event, ['conferenceDataVersion' => 1]);
            $meetLink = $event->getHangoutLink();
            $update = Schedule::updateMeetLink($session->id, $meetLink);
            if ($update) {
                Yii::$app->session->setFlash('success', 'Посилання на Google Meet успішно додано.');
                return $this->redirect(['specialist/session-details', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('error', 'Помилка при оновленні посилання Google Meet');
            }
        } catch (\Exception $e) {
            Yii::error("Не вдалося створити зустріч: " . $e->getMessage(), 'google-meet');
            Yii::$app->session->setFlash('error', 'Помилка при створенні посилання Google Meet');
            return $this->redirect(['specialist/session-details', 'id' => $id]);
        }
    }


    public function actionCreateArticle()
    {
        return $this->redirect(['article/create-article']);
    }
}
