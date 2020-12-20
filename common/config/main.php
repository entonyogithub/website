<?php

return [
    'timeZone' => 'Asia/Amman',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@fronturl' => '/',
        '@admindurl' => '/admin',
        '@images' => '/images',
        '@original' => '/uploaded/original',
        '@backend_images' => '/admin/images',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['Guests'],
        ],
        'notify' => [
            'class' => 'common\components\Notification',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
