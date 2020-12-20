<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\base\InvalidParamException;

class HomeController extends \yii\web\Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

//    /**
//     * @inheritdoc
//     */
//    public function actions() {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
//    }

    public function actionIndex() {
        $this->redirect('/admin/admin-dashboard/login');
        return $this->render('index');
    }

    public function actionError() {
        return $this->redirect('/admin/admin-dashboard/login');
    }

    /**
     * Logout function
     * @return type
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
