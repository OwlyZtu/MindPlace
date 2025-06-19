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
            'appendTimestamp' => true,
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'dirMode' => 0777,
        ],
        's3Storage' => [
            'class' => app\components\S3Storage::class,
            'key' => $_ENV['AWS_ACCESS_KEY_ID'] ?? null,
            'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'] ?? null,
            'bucket' => $_ENV['AWS_BUCKET'] ?? 'mindplacediploma',
            'region' => $_ENV['AWS_REGION'] ?? 'eu-north-1',
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
        'symfonyMailer' => [
            'class' => 'app\components\SymfonyMailer',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'except' => [
                        'yii\web\HttpException:404',
                        'application.runtime.logs.*',
                    ],
                    'maskVars' => [
                        '_SERVER.AWS_ACCESS_KEY_ID',
                        '_SERVER.AWS_SECRET_ACCESS_KEY',
                        '_SERVER.DSN_MAILER',
                        '_SERVER.USERNAME_MAILER',
                        '_SERVER.PASSWORD_MAILER',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['user-settings-validation'],
                    'logFile' => '@runtime/logs/validation-errors.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['therapist-join'],
                    'logFile' => '@runtime/logs/therapist-join.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error'],
                    'categories' => ['admin.*'],
                    'logFile' => '@runtime/logs/admin.log',
                    'logVars' => [],
                    'prefix' => fn($message) => date('Y-m-d H:i:s'),

                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'admin/specialist-request' => 'admin/specialist-request/index',
                'admin/specialist-request/<action:\w+>/<id:\d+>' => 'admin/specialist-request/<action>',
                'admin/specialist-request/<action:\w+>' => 'admin/specialist-request/<action>',
                'admin/specialist-request/<action>/<id:\d+>' => 'admin/specialist-request/<action>',

                'admin/article-review' => 'admin/article-review/index',
                'admin/article-review/<action:\w+>/<id:\d+>' => 'admin/article-review/<action>',
                'admin/article-review/<action:\w+>' => 'admin/article-review/<action>',
                'admin/article-review/<id:\d+>' => 'admin/article-review/view',
                'admin/article-review/<id:\d+>/<action:\w+>' => 'admin/article-review/<action>',

                'specialists' => 'specialist/index',
                'specialist/<id:\d+>' => 'specialist/view',
                'specialist/<id:\d+>/book-session' => 'specialist/book-session',
                'specialist/<id:\d+>/session-details' => 'specialist/session-details',
                'specialist/<id:\d+>/profile' => 'specialist/profile',

                'articles' => 'article/index',
                'articles/<action:\w+>' => 'article/<action>',
                'articles/<id:\d+>' => 'article/view',
                'articles/<id:\d+>/<action:\w+>' => 'article/<action>',

            ],
        ],

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
