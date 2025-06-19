<?php

namespace app\components;

use Yii;
use Google\Client;
use Google\Service\Calendar;

class GoogleClient
{
    public static function getClient(): \Google\Client
    {
        $client = new \Google\Client();
        $client->setApplicationName('MindPlace');
        $client->setScopes([\Google\Service\Calendar::CALENDAR]);
        $client->setAuthConfig(Yii::getAlias('@app/config/google-credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
    
        $tokenPath = Yii::getAlias('@app/runtime/google-token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
    
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($accessToken)) {
                Yii::warning('Invalid JSON in google-token.json: ' . json_last_error_msg(), 'google-token');
            } else {
                $client->setAccessToken($accessToken);
            }
        }
    
        return $client;
    }
    
}
