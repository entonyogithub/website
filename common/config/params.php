<?php

return [
    'adminEmail' => 'admin@ucan.com',
    'supportEmail' => 'support@ucan.com',
    'user.passwordResetTokenExpire' => 3600,
    'user.ActivationExpire' => 3600,
    'googleMapsApiKey' => 'AIzaSyDWdZlNGm1FycZJMWom0G5zcBgtN9gVHmY',
    'gender' => array(1 => Yii::t('app', 'Male'), 2 => Yii::t('app', 'Female')),
    'userStatus' => [
        common\models\User::STATUS_NOT_ACTIVE => 'Not Active',
        common\models\User::STATUS_ACTIVE => 'Active',
        common\models\User::STATUS_BAN => 'Ban'
    ],
    'image' => [
        'w120x120' => [
            'height' => 120,
            'width' => 120,
            'path' => '@frontend/web/upload/w120x120',
            'url' => '@fronturl/uploaded/w120x120'
        ],
        'w160x160' => [
            'height' => 160,
            'width' => 160,
            'path' => '@frontend/web/upload/w160x160',
            'url' => '@fronturl/uploaded/w160x160'
        ],
    ]
];
