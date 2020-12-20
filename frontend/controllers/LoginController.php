<?php
namespace frontend\controllers;

use Yii;
use \common\models\LoginForm;

class LoginController extends \yii\web\Controller {

    public function actionIndex() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('index', [
                        'model' => $model,
            ]);
        }
    }

}
