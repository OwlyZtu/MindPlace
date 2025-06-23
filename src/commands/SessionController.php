<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Schedule;

class SessionController extends Controller
{
    public function actionUpdateCompleted()
    {
        $now = new \DateTime('now', new \DateTimeZone(\Yii::$app->timeZone));
        $sessions = Schedule::find()
            ->where(['status' => 'booked'])
            ->all();

        $updated = 0;
        foreach ($sessions as $session) {
            $start = new \DateTime($session->datetime, new \DateTimeZone(\Yii::$app->timeZone));
            $end = (clone $start)->add(new \DateInterval('PT' . $session->duration . 'M'));
            if ($end <= $now) {
                $session->status = 'completed';
                $session->save(false);
                $updated++;
            }
        }

        echo "Оновлено $updated сесій\n";
    }
}
