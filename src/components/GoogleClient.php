<?php
namespace app\components;

use Yii;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Oauth2;
use Google\Service\PeopleService;

class GoogleClient
{
    public static function getClient(): Client
    {
        $client = new Client();
        $client->setApplicationName('MindPlace');
        $client->addScope([
            Calendar::CALENDAR,
            Oauth2::USERINFO_EMAIL,
            Oauth2::USERINFO_PROFILE,
            'https://www.googleapis.com/auth/user.birthday.read',
        ]);
        $client->setAuthConfig(Yii::getAlias('@app/config/google-credentials.json'));
        $client->setPrompt('consent');
        $client->setAccessType('offline');
        $client->setRedirectUri('http://localhost:8080/site/google-callback');
        $tokenPath = Yii::getAlias('@app/runtime/google-token.json');
        if (file_exists($tokenPath)) {
            $json = file_get_contents($tokenPath);
            $accessToken = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($accessToken) || empty($accessToken)) {
                Yii::warning('Invalid or empty JSON in google-token.json: ' . json_last_error_msg(), 'google-token');
            } else {
                $client->setAccessToken($accessToken);
            }
        }

        return $client;
    }

    public static function getUserBirthdate(Client $client): ?string
    {
        $peopleService = new PeopleService($client);
        $profile = $peopleService->people->get('people/me', ['personFields' => 'birthdays']);
        $birthdays = $profile->getBirthdays();

        if (!empty($birthdays)) {
            $birthday = $birthdays[0]->getDate();
            if ($birthday) {
                $year = $birthday->getYear() ?: 0;
                $month = $birthday->getMonth() ?: 0;
                $day = $birthday->getDay() ?: 0;

                if ($year && $month && $day) {
                    return sprintf('%04d-%02d-%02d', $year, $month, $day);
                }
            }
        }

        return null;
    }
}
