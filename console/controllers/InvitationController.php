<?php

namespace console\controllers;

use Yii;
use \backend\models\Invitation;

class InvitationController extends \yii\console\Controller {

    public function actionIndex() {

        $invitations = Invitation::findAll(['sent' => Invitation::STATUS_PENDING]);
        foreach ($invitations as $invitation) {
            Yii::$app->notify->SendInvitation(['email' => $invitation->email, 'invitation' => $invitation]);
            $invitation->sent = 1;
            $invitation->save();
        }
    }

}
