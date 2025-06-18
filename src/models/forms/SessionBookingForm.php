<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Schedule;
use Google\Service\Calendar\Event;
use app\components\GoogleClient;

class SessionBookingForm extends Model
{
    public $therapy_types;
    public $theme;
    public $approach_type;
    public $format;
    public $comment;
    public $add_to_google_calendar;

    public function rules()
    {
        return [
            [['therapy_types', 'format'], 'required'],
            [['theme', 'approach_type', 'comment'], 'safe'],
            ['add_to_google_calendar', 'boolean'],
        ];
    }

    public function book($schedule)
    {
        if (!$this->validate()) {
            return false;
        }
        $data = [
            'client_id' => Yii::$app->user->id,
            'status' => Schedule::STATUS_BOOKED,
            'details' => [
                'therapy_types' => $this->therapy_types,
                'theme' => $this->theme,
                'approach_type' => $this->approach_type,
                'format' => $this->format,
                'comment' => $this->comment,
            ],
        ];
        $session = Schedule::updateSchedule($schedule->id, $data);
        if ($session) {
            $this->addToCalendarForDoctor($schedule->doctor_id, $schedule->datetime);
            return $session;
        }
        return false;
    }

    public function addToCalendar()
    {
        $client = GoogleClient::getClient();
        if ($client->isAccessTokenExpired()) {
            Yii::warning('Google access token is expired.', 'calendar');
        } else {
            $calendarService = new \Google\Service\Calendar($client);

            $doctorName = $this->getDoctor($this->doctor_id)->name;
            $event = new Event([
                'summary' => 'Консультація з ' . $doctorName,
                'description' => 'Сеанс на платформі MindPlace',
                'start' => [
                    'dateTime' => date(DATE_RFC3339, strtotime($this->datetime)),
                    'timeZone' => 'Europe/Kyiv',
                ],
                'end' => [
                    'dateTime' => date(DATE_RFC3339, strtotime($this->getEndTime())),
                    'timeZone' => 'Europe/Kyiv',
                ],
            ]);

            try {
                $calendarService->events->insert('primary', $event);
                Yii::$app->session->setFlash('success', 'Запис створено та додано в Google Calendar.');
            } catch (\Exception $e) {
                Yii::error('Google Calendar insert error: ' . $e->getMessage(), 'calendar');
                Yii::$app->session->setFlash('warning', 'Запис створено, але не вдалося додати в Google Calendar.');
            }
        }
    }

    public function addToCalendarForDoctor($doctorId, $datetime, $duration = 50)
    {
        // Отримуємо користувача-лікаря
        $doctor = User::findById($doctorId);
        if (!$doctor || !$doctor->google_token) {
            Yii::error("Лікар не має токену Google або не знайдений", 'calendar');
            return false;
        }

        // Отримуємо клієнт з токеном лікаря
        $client = GoogleClient::getClient($doctor->google_token); // Переконайся, що метод приймає токен
        if ($client->isAccessTokenExpired()) {
            Yii::warning('Google токен лікаря протермінований', 'calendar');
            return false;
        }

        $calendarService = new \Google\Service\Calendar($client);

        $clientName = Yii::$app->user->identity->name ?? 'Клієнт';

        $event = new Event([
            'summary' => 'Сеанс з клієнтом ' . $clientName,
            'description' => 'Консультація на платформі MindPlace',
            'start' => [
                'dateTime' => date(DATE_RFC3339, strtotime($datetime)),
                'timeZone' => 'Europe/Kyiv',
            ],
            'end' => [
                'dateTime' => date(DATE_RFC3339, strtotime("+$duration minutes", strtotime($datetime))),
                'timeZone' => 'Europe/Kyiv',
            ],
        ]);

        try {
            $calendarService->events->insert('primary', $event);
            Yii::info('Запис додано до календаря лікаря: ' . $doctor->name, 'calendar');
            return true;
        } catch (\Exception $e) {
            Yii::error('Помилка додавання в календар лікаря: ' . $e->getMessage(), 'calendar');
            return false;
        }
    }
}
