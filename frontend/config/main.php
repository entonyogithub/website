<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'name' => 'Ucan',
    'homeUrl' => '/',
    'sourceLanguage' => 'en-US',
    'bootstrap' => ['log'],
    'defaultRoute' => 'home/index',
    'controllerNamespace' => 'frontend\controllers',
//    'on beforeAction' => function ($event) {
//        
//        return Yii::$app->controller->redirect('/admin/admin-dashboard/login');
//    },
    'modules' => [
        'oauth2' => [
            'class' => 'springdev\yii2\oauth2mysqlserver\Module',
            'tokenParamName' => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap' => [
                'user_credentials' => 'common\models\User'
            ],
            'grantTypes' => [
                'client_credentials' => [
                    'class' => 'OAuth2\GrantType\ClientCredentials',
                    'allow_public_clients' => false
                ],
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials'
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ],
        ],
        'api' => [
            'class' => 'app\modules\api\api',
        ],
    ],
    'components' => [
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',],
//            'bundles' => [
//                'yii\bootstrap\BootstrapPluginAsset' => [
//                    'js' => []
//                ],
//                'yii\bootstrap\BootstrapAsset' => [
//                    'css' => []
//                ]
//            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => ['login/index'],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    if (is_array($response->data)) {
                        if (!$response->isSuccessful && isset($response->data['type']) && $response->data['type'] == 'springdev\yii2\oauth2mysqlserver\exceptions\HttpException') {
                            $response->data = [
                                'success' => 0,
                                'errors' => [$response->data['message']],
                            ];
                            $response->statusCode = 401;
                        }
                    }
                }
            },
        ],
        'request' => [
            'baseUrl' => '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
//                '/' => 'site',
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'api\user', 'pluralize' => true, 'except' => ['index']],
                'uploaded/<dir>/<image>' => 'uploaded/index',
                'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'home/error',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
    ],
    'params' => $params,
];
