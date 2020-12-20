<?php

namespace frontend\controllers;

use Yii;
use common\models\ContactRequest;
use \yii\web\NotFoundHttpException;

class ContactUsController extends \yii\web\Controller {

    public function actionIndex() {
        $model = new ContactRequest();

        if ($model->load(Yii::$app->request->post())) {
            $model->read = ContactRequest::NOT_READ_FLAG;
            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->notify->VolunteerRequest(['email' => $model->email, 'model' => $model]);
                }
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Thank you for contacting us, we will reply to your request as soon as possible'));
                return $this->redirect(['/contact-us']);
            }
        }
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

}
