<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'uk-UA', // або 'en-US' як мова за замовчуванням
    'sourceLanguage' => 'en-US',
    'components' => [
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'dirMode' => 0777,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JERrznjt36oDWBHtrkNEvUlrkG4xCIWC',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true, // !!!set this property to false to send mails to real email addresses,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'dsn' => 'smtp://nightmare.owl16@gmail.com:pkue wkyj vjwc posb@smtp.gmail.com:587',
                'scheme' => 'smtp',
                'host' => 'smtp.gmail.com',
                'username' => 'nightmare.owl16@gmail.com',
                'password' => 'pkue wkyj vjwc posb', // Не звичайний пароль, а спеціальний пароль додатку
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'symfonyMailer' => [
            'class' => 'app\components\SymfonyMailer',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                // Окремий файл для логування помилок валідації
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['user-settings-validation'],
                    'logFile' => '@runtime/logs/validation-errors.log',
                    'logVars' => [],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'ua',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '172.19.0.*', '172.18.0.*'],  // Add Docker network
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '172.19.0.*'],  // Add Docker network
    ];
}

return $config;
