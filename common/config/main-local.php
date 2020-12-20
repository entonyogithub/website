<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=database-1.ckdtggtq5s7e.us-east-1.rds.amazonaws.com;dbname=entoneyo',
            'username' => 'root',
            'password' => 'zSB32rhqyNDHVVVC',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
