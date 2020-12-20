<?php

namespace backend\controllers;

use Yii;
use common\models\UserPayment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminManageUserPaymentsController implements the CRUD actions for UserPayment model.
 */
class AdminManageUserPaymentsController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserPayment models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => UserPayment::find(),
        ]);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        $model = new UserPayment();
        if ($model->load(Yii::$app->request->post())) {
            $user = \common\models\User::find()->where(['id' => $id, 'role' => 'Users'])->notDeleted()->one();
            $model->uid = $user->id;
            if ($model->validate()) {
                if ($user->userProfile->balance > $model->amount) {
                    if ($model->save()) {
                        $user->userProfile->balance -= $model->amount;
                        $user->userProfile->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $model->addError('amount', 'User balance is below the selected amount');
                }
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($user->userProfile->balance > $model->amount) {
                    if ($model->save()) {
                        $user->userProfile->balance -= $model->amount;
                        $user->userProfile->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $model->addError('amount', 'User balance is below the selected amount');
                }
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserPayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->user->userProfile->balance += $model->amount;
        $model->user->userProfile->save();
        $model->delete();
        return $this->redirect(['/admin-manage-users/view', "id" => $model->uid, '#' => 'w6-tab1']);
    }

    /**
     * Finds the UserPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
