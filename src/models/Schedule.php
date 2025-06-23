<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $doctor_id
 * @property string $datetime
 * @property int $duration
 * @property string|null $details
 * @property int|null $client_id
 * @property string|null $status
 * @property string|null $meet_url
 * @property string|null $recommendations
 */
class Schedule extends ActiveRecord
{
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_BOOKED = 'booked';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'cancelled';

    public static function getFutureTimeCondition(): array
    {
        return ['>', 'datetime', date('Y-m-d H:i:s')];
    }
    public static function getPastTimeCondition(): array
    {
        return ['<', 'datetime', date('Y-m-d H:i:s')];
    }

    public static function tableName()
    {
        return 'schedule';
    }

    public function rules()
    {
        return [
            [['doctor_id', 'datetime', 'duration'], 'required'],
            [['doctor_id', 'duration', 'client_id'], 'integer'],
            [['datetime'], 'datetime', 'format' => 'php:Y-m-d\TH:i'],
            [['status'], 'string', 'max' => 50],
            [['meet_url'], 'string', 'max' => 255],
            [['recommendations'], 'string'],
            ['details', 'safe'],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['doctor_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function beforeValidate()
    {
        $this->datetime = date('Y-m-d\TH:i', strtotime($this->datetime));
        return parent::beforeValidate();
    }


    public static function createSchedule($data)
    {
        $schedule = new Schedule();
        if (!$schedule->validate()) {
            Yii::error($schedule->getErrors(), 'session-create');
            return null;
        }
        $schedule->doctor_id = $data['doctor_id'] ?? null;
        $schedule->datetime = $data['datetime'] ?? null;
        $schedule->duration = $data['duration'] ?? null;
        $schedule->client_id = $data['client_id'] ?? null;
        $schedule->details = $data['details'] ?? null;
        $schedule->status = self::STATUS_SCHEDULED;
        $schedule->meet_url = $data['meetUrl'] ?? null;
        $schedule->recommendations = $data['recommendations'] ?? null;
        if (!$schedule->save()) {
            Yii::error('Failed to create session' . json_encode($schedule->getErrors()), 'session-create');
            Yii::$app->session->setFlash('error', 'Failed to create schedule. Please try again later.');
            return null;
        } else {
            Yii::$app->session->setFlash('success', 'Schedule created successfully.');
            return $schedule;
        }
    }
    public static function updateSchedule($id, $data)
    {
        $schedule = self::getScheduleById($id);
        if (!$schedule) {
            return null;
        }
        if (!$schedule->validate()) {
            Yii::error($schedule->getErrors(), 'session-update');
            return null;
        }
        $schedule->doctor_id = $data['doctor_id'] ?? $schedule->doctor_id;
        $schedule->client_id = $data['client_id'] ?? $schedule->client_id;
        $schedule->status = $data['status'] ?? $schedule->status;
        $schedule->datetime = $data['datetime'] ?? $schedule->datetime;
        $schedule->duration = $data['duration'] ?? $schedule->duration;
        $schedule->meet_url = $data['meetUrl'] ?? $schedule->meet_url;
        $schedule->details = $data['details'] ?? $schedule->details;
        $schedule->recommendations = $data['recommendations'] ?? $schedule->recommendations;
        Yii::info($schedule->getAttributes(), 'session-update');
        if (!$schedule->save()) {
            Yii::error('Failed to update session' . json_encode($schedule->getErrors()), 'session-update');
            return null;
        } else {
            return $schedule;
        }
    }

    public static function updateMeetLink($id, $link)
    {
        $schedule = self::getScheduleById($id);
        if (!$schedule) {
            return null;
        }
        $schedule->meet_url = $link;
        if (!$schedule->save()) {
            Yii::error('Failed to update session link' . json_encode($schedule->getErrors()), 'session-update');
            return null;
        }
        return $schedule;
    }

    public static function deleteSchedule($id)
    {
        $schedule = self::getScheduleById($id);
        if (!$schedule) {
            return null;
        }
        if (!$schedule->delete()) {
            Yii::error('Failed to delete session' . json_encode($schedule->getErrors()), 'session-delete');
            return null;
        } else {
            Yii::$app->session->setFlash('success', 'Schedule deleted successfully.');
            return $schedule;
        }
    }

    public static function ifCanLeaveReview($client_id, $doctor_id)
    {
        return Schedule::find()
            ->where([
                'client_id' => $client_id,
                'doctor_id' => $doctor_id,
                'status' => Schedule::STATUS_COMPLETED,
            ])
            ->exists();
    }
    public static function getSchedulesByDoctorId($doctorId, $timeCondition = null, $onlyBusy = false)
    {
        $schedulesQuery = self::find()
            ->where(['doctor_id' => $doctorId]);
        if ($onlyBusy) {
            $schedulesQuery->andWhere(['IS NOT', 'session_id', null]);
        }
        if ($timeCondition) {
            $schedulesQuery->andWhere([$timeCondition[0], 'datetime', $timeCondition[2] ?? $timeCondition[1]]);
        }
        switch ($timeCondition[0]) {
            case '>=':
                $schedulesQuery->orderBy(['datetime' => SORT_ASC]);
                break;
            case '<':
                $schedulesQuery->orderBy(['datetime' => SORT_DESC]);
                break;
            default:
                $schedulesQuery->orderBy(['datetime' => SORT_ASC]);
                break;
        }
        return $schedulesQuery;
    }

    public static function getSchedulesByClientId($clientId, $timeCondition = null)
    {
        $schedulesQuery = self::find()
            ->where(['client_id' => $clientId]);
        if ($timeCondition) {
            $schedulesQuery->andWhere([$timeCondition[0], 'datetime', $timeCondition[2] ?? $timeCondition[1]]);
        }
        switch ($timeCondition[0]) {
            case '>=':
                $schedulesQuery->orderBy(['datetime' => SORT_ASC]);
                break;
            case '<':
                $schedulesQuery->orderBy(['datetime' => SORT_DESC]);
                break;
            default:
                $schedulesQuery->orderBy(['datetime' => SORT_ASC]);
                break;
        }
        return $schedulesQuery;
    }

    public static function getScheduleById($id)
    {
        return self::findOne(['id' => $id]);
    }

    public function getDoctor()
    {
        return $this->hasOne(User::class, ['id' => 'doctor_id']);
    }

    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
    }

    public function getEndTime()
    {
        $start = new \DateTime($this->datetime, new \DateTimeZone(Yii::$app->timeZone));
        $start->add(new \DateInterval('PT' . $this->duration . 'M'));
        return $start->format('H:i');
    }

    public function isBooked(): bool
    {
        return !is_null($this->client_id);
    }

    public function getTherapyTypes()
    {
        return $this->details['therapy_types'] ?? null;
    }

    public function setTherapyTypes($value)
    {
        $details = $this->details ?? [];
        $details['therapy_types'] = $value;
        $this->details = $details;
    }

    public function getTheme()
    {
        return $this->details['theme'] ?? null;
    }

    public function setTheme($value)
    {
        $details = $this->details ?? [];
        $details['theme'] = $value;
        $this->details = $details;
    }

    public function getApproachType()
    {
        return $this->details['approach_type'] ?? null;
    }
    public function setApproachType($value)
    {
        $details = $this->details ?? [];
        $details['approach_type'] = $value;
        $this->details = $details;
    }

    public function getFormat()
    {
        return $this->details['format'] ?? null;
    }

    public function setFormat($value)
    {
        $details = $this->details ?? [];
        $details['format'] = $value;
        $this->details = $details;
    }
    public function getComment()
    {
        return $this->details['comment'] ?? null;
    }

    public function setComment($value)
    {
        $details = $this->details ?? [];
        $details['comment'] = $value;
        $this->details = $details;
    }
}
