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


class SpecialistController extends Controller
{
    /**
     * Displays specialists page with optional filtering.
     * @return string
     */
    public function actionIndex()
    {
        $model = new FilterForm();

        if (Yii::$app->request->get('clear')) {
            Yii::$app->session->remove('filterData');
            return $this->redirect(['specialists/index']);
        }

        $filterData = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->saveFilterToSession()) {
                $filterData = FilterForm::getSessionFilter();
            }
        } else {
            $filterData = FilterForm::getSessionFilter();
            if (empty($filterData)) {
                $filterData = ['role' => 'specialist'];
            }
        }

        $query = User::find()->where(['role' => 'specialist']);

        if (!empty($filterData['city'])) {
            $query->andWhere(['city' => $filterData['city']]);
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
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $specialist = User::findOne(['id' => $id, 'role' => 'specialist']);
        if (!$specialist) {
            throw new NotFoundHttpException("Спеціаліста не знайдено.");
        }

        $specialistSchedules = Schedule::getSchedulesByDoctorId($specialist->id, Schedule::getFutureTimeCondition());
        $reviews = Review::getReviewsByDoctorId($specialist->id);
        $avgRating = Review::getAverageRating($specialist->id);
        $canLeaveReview = Schedule::ifCanLeaveReview(Yii::$app->user->identity->id, $specialist->id);

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
                    $model->addToCalendar();
                }
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
        return $this->render('session-details', [
            'session' => $session,
            'doctor' => Yii::$app->user->identity,
            'user' => $session->client,
            'therapyTypes' => FormOptions::getDoctorOptions($session->getTherapyTypes(), 'therapy_types'),
            'themes' => FormOptions::getDoctorOptions($session->getTheme(), 'theme'),
            'approachTypes' => FormOptions::getDoctorOptions($session->getApproachType(), 'approach_type'),
        ]);
    }
}
