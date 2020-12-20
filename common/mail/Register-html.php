<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/activation', 'token' => $user->activation_code]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->profile->name) ?>,</p>

    <p>Follow the link below to Activate your account:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
