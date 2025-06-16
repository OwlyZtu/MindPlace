<?php

namespace app\services;

use Yii;
use yii\base\Model;

class PhotoService extends Model
{
    public static function checkImageUrl(string $url): string
    {
        if (!empty($url)) {
            $headers = @get_headers($url);
            if ($headers && strpos($headers[0], '200') !== false) {
                return $url;
            }
        }
        return Yii::getAlias('@web') . "/images/defaultProfile.jpg";
    }
}
