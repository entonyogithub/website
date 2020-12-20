<?php

namespace frontend\controllers;

class PageController extends \yii\web\Controller {

    public function actionAboutUs() {
        $model = $this->findModel(1);
        return $this->render('about_us', ['model' => $model]);
    }

    public function actionPrivacyPolicy() {
         $model = $this->findModel(2);
        return $this->render('privacy', ['model' => $model]);
    }

    public function actionTermsAndConditions() {
        $model = $this->findModel(3);
        return $this->render('terms', ['model' => $model]);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = \common\models\Page::find()->where(['id' => $id])->one()) !== null) {

            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

}
