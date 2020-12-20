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
class AdminManageUsersController extends Controller {

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
    public function actionIndex() {

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
        $users = $search->search(Yii::$app->request->queryParams);
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
        $model = $this->findModel($id);
        $payments = new ActiveDataProvider([
            'query' => \common\models\UserPayment::find()->where(['uid' => $model->id])->orderBy('created_at DESC'),
        ]);
        $uploads = new ActiveDataProvider([
            'query' => \common\models\StudentUpload::find()->where(['uid' => $model->id])->orderBy('created_at DESC'),
        ]);
        $logs = new \yii\data\ActiveDataProvider([
            'query' => \common\models\AttendanceLog::find()->where(['uid' => $model->id])->orderBy('created_at DESC'),
        ]);
        $listenings =  new ActiveDataProvider([
            'query' => \common\models\StudentListening::find()->where(['uid' => $model->id])->orderBy('created_at DESC'),
        ]);
        return $this->render('view', [
                    'model' => $model,
                    'payments' => $payments,
                    'uploads' => $uploads,
                    'logs' => $logs,
                    'listenings'=>$listenings
//                    'favourites'=>$favourites,
//                    'contacts'=>$contacts
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new User;
        $model->role = 'Users';
        $profile = new \common\models\UserProfile;
        if ($model->load(Yii::$app->request->post())) {
            $profile->load(Yii::$app->request->post());
            if (\yii\base\Model::validateMultiple([$model, $profile])) {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
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
        $profile = $model->userProfile;
        if ($model->load(Yii::$app->request->post())) {
            $profile->load(Yii::$app->request->post());
            if (\yii\base\Model::validateMultiple([$model, $profile])) {
                if ($model->save()) {
                    $profile->uid = $model->id;
                    $profile->save(false);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    /**
     * User profile action
     * @return type
     */
    public function actionProfile() {
        $model = $this->findModel(Yii::$app->user->id);
        $profile = $model->profile;
        $profile->scenario = 'update';
        $photo_options = \backend\helpers\CustomHelper::getImageOptions($profile, 'photo');
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
        return $this->render('profile', ['model' => $model, 'profile' => $profile, 'photo_options' => $photo_options]);
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
            return $this->redirect(['/admin-manage-admins/update', 'id' => $user->id]);
        }
        return $this->render('adminchangePassowrd', ['model' => $model, 'user' => $user]);
    }

    /**
     * Send message to user
     * @return type
     */
    public function actionMessages($id) {
        $user = $this->findModel($id);
        \common\models\Message::updateAll(['read' => \common\models\Enum::ANSWER_YES], ['uid' => $user->id, 'read' => \common\models\Enum::ANSWER_NO, 'type' => \common\models\Message::MESSAGE_USER]);
        $messages = \common\models\Message::find()->where(['uid' => $id])->orderBy('created_at ASC')->all();
        $message = new \backend\models\SendMessage();
        if ($message->load(Yii::$app->request->post())) {
            if ($message->validate()) {
                $new_message = new \common\models\Message();
                $new_message->uid = $id;
                $new_message->message = $message->message;
                $new_message->type = \common\models\Message::MESSAGE_ADMIN;
                if ($new_message->save()) {
                    $this->refresh();
                }
            }
        }
        return $this->render('messages', [
                    'messages' => $messages,
                    'message' => $message
        ]);
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
     * Load profile based on user type
     * @param type $role
     * @param type $model
     * @return type
     */
    private function loadProfile($role, $model) {
        if ($role == 'Stores') {
            $profile = $model->store;
        } else {
            $profile = $model->profile;
        }
        return $profile;
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
