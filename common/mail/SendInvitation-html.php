<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$invitationLink = Yii::$app->urlManager->createAbsoluteUrl(['signup', 'email'=>$invitation->email,'token' => $invitation->verfiy_code]);

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($invitation->email) ?>,</p>

    <p>Click to register :</p>

    <p><?= Html::a(Html::encode($invitationLink), $invitationLink) ?></p>
</div>
