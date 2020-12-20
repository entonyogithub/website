<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\Profile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class AdminUserController extends Controller {

    public $enableCsrfValidation = false;

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex($role) {
        
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $user = User::findOne($id);
            $output = ['output' => '', 'message' => 'Error'];
            if ($user) {
                $values = current($_POST['User']);
                $value = $values['status'];
                $user->status = $value;
                if ($user->validate()) {
                    $user->save();
                    $output = ['output' => Yii::$app->params['userStatus'][$user->status], 'message' => ''];
                }
            }
            $out = \yii\helpers\Json::encode($output);
            echo $out;
            return;
        }
        $search = new \backend\models\UserSearch();
        $users = $search->search(Yii::$app->request->queryParams,$role);
        return $this->render('index', [
                    'dataProvider' => $users,
                    'search' => $search,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new User;
        $model->scenario = 'insert';
        $profile = new \common\models\Profile;
        $profile->scenario = 'insert';
        $countries = \yii\helpers\ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            $profile->load(Yii::$app->request->post());
            if (\yii\base\Model::validateMultiple([$model, $profile])) {
                if ($model->save()) {
                    $profile->uid = $model->id;
                    $profile->save(false);
                    $model->addRole($model->role, $model);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->role = User::getUserRole($model->id);
        $old_role = User::getUserRole($model->id);
        $profile = $model->profile;
        $profile->scenario = 'update';
        if ($model->load(Yii::$app->request->post())) {
            $profile->load(Yii::$app->request->post());
            $model->role = Yii::$app->request->post("User")['role'];
            if (\yii\base\Model::validateMultiple([$model, $profile])) {
                if ($model->save()) {
                    $profile->uid = $model->id;
                    $profile->save(false);
                    if($old_role != $model->role){
                        $model->removeRole($old_role, $model);
                        $model->addRole($model->role, $model);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', ['model' => $model, 'profile' => $profile]);
    }

    /**
     * User profile action
     * @return type
     */
    public function actionProfile() {
        $model = $this->findModel(Yii::$app->user->id);
        $profile = $model->profile;
        $profile->scenario = 'update';
        if ($model->load(Yii::$app->request->post())) {
            $profile->load(Yii::$app->request->post());
            if (\yii\base\Model::validateMultiple([$model, $profile])) {
                if ($model->save()) {
                    $profile->save(false);
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Profile updated successfully'));
                    return $this->redirect(['profile']);
                }
            }
        }
        return $this->render('profile', ['model' => $model, 'profile' => $profile]);
    }
    /**
     * Change user password 
     * @return type
     */
    public function actionAdminChangePassword($id) {
        $user = $this->findModel($id);
        $model = new \backend\models\AdminChangePassword;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $user->setPassword($model->new_password);
                $user->save(false);
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Password updated successfully'));
                return $this->redirect(['/admin-user/update','id'=>$user->id]);
           
        }
        return $this->render('adminchangePassowrd', ['model' => $model, 'user' => $user]);
    }
    
    /**
     * Change user password 
     * @return type
     */
    public function actionChangePassword() {
        $user = $this->findModel(Yii::$app->user->id);
        $model = new \backend\models\ChangePassword;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $validat_pass = Yii::$app->security->validatePassword($model->old_password, $user->password_hash);
            if ($validat_pass) {
                $user->setPassword($model->new_password);
                $user->save(false);
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Password updated successfully'));
                return $this->redirect(['profile']);
            } else {
                $model->addError('old_password', Yii::t('app', 'Old password is invalid'));
            }
        }
        return $this->render('changePassowrd', ['model' => $model, 'user' => $user]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->df = User::DELETED;
        $role = User::getUserRole($model->id);
        $model->save(false);
        return $this->redirect(['index', 'role' => $role]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::find()->where(['id' => $id])->notDeleted()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
