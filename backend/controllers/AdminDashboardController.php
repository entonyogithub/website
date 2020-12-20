<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class AdminDashboardController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id == 'error' && !\Yii::$app->user->id)
                $this->layout = '@backend/views/layouts/main-login';
            return true;
        } else {
            return false;
        }
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            $role = \Yii::$app->user->identity->role;
            if($role == 'Users'){
                 return $this->redirect('/admin/admin-user-dashboard');
            }
            return $this->goHome();
        }

        $model = new \backend\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($model->user->role === 'Users') {
                return $this->redirect('/admin/admin-user-dashboard');
            } else {
                return $this->redirect('/admin/admin-dashboard');
            }
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
