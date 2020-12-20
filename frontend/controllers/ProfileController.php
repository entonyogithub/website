<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Profile;
use yii\data\ActiveDataProvider;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\Event;
use yii\web\NotFoundHttpException;

class ProfileController extends \yii\web\Controller {

    public function actions() {
        return [
            'cities' => [
                'class' => '\common\actions\CitiesAction',
            ],
            'districts' => [
                'class' => '\common\actions\DistrictAction',
            ],
        ];
    }

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

    /**
     * Update profile 
     * @return type
     */
    public function actionView($id) {
        $user = $this->findModel($id);
        $new_recommendation = new \common\models\UserRecommendation;
        $recommendation = new ActiveDataProvider([
            'query' => \common\models\UserRecommendation::find()->where(['uid' => $user->id])->display()->orderBy('created_at DESC'),
            'pagination' => ['pageSize' => 5]
        ]);
         $posts = new ActiveDataProvider([
            'query' => \common\models\UserPost::find()->where(['uid' => $user->id])->active()->orderBy('created_at DESC'),
            'pagination' => ['pageSize' => 3]
        ]);
        $profile = $user->profile;
        return $this->render('view', ['user' => $user, 'profile' => $profile, 'recommendation' => $recommendation, 'new_recommendation' => $new_recommendation, 'posts' => $posts]);
    }

    /**
     * Show all posts 
     * @return type
     */
    public function actionPosts($id) {
        $user = $this->findModel($id);
        $new_post = new \common\models\UserPost;
        $posts = new ActiveDataProvider([
            'query' => \common\models\UserPost::find()->where(['uid' => $user->id])->active()->orderBy('created_at DESC'),
            'pagination' => ['pageSize' => 10]
        ]);
        $profile = $user->profile;
        return $this->render('posts', ['user' => $user, 'profile' => $profile, 'new_post' => $new_post, 'posts' => $posts]);
    }

    /**
     * Add new post
     * @return type
     */
    public function actionAddPost() {

        $new_post = new \common\models\UserPost;
        $new_post->load(\Yii::$app->request->post());
        $new_post->uid = \Yii::$app->user->id;
        $new_post->status = \common\models\UserPost::STATUS_ACTIVE;
        if ($new_post->validate()) {
            $new_post->save();
            return json_encode(['success' => 1]);
        }
        return json_encode(['success' => 0, 'message' => Yii::t('app', '')]);
    }
/**
 * Add post comment
 * @return type
 */
    public function actionAddComment() {
        $new_comment = new \common\models\PostComment;
        $new_comment->load(\Yii::$app->request->post());
        $new_comment->uid = \Yii::$app->user->id;
        $new_comment->post_id = \Yii::$app->request->post('post_id');
        $new_comment->status = \common\models\PostComment::STATUS_ACTIVE;
        if ($new_comment->validate()) {
            $new_comment->save();
            return json_encode(['success' => 1]);
        }
        return json_encode(['success' => 0]);
    }

    public function actionEditProfile() {
        $model = $this->findModel(Yii::$app->user->id);
        $model->role = User::getUserRole($model->id);
        $profile = $model->profile;
        $user_skills = \yii\helpers\ArrayHelper::map($model->skill, 'skill_id', 'skill_id');
        $profile->scenario = 'update';
        $countries = \yii\helpers\ArrayHelper::map(\common\models\Country::find()->all(), 'id', 'name');
        $skills = \yii\helpers\ArrayHelper::map(\common\models\Skill::find()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $submit_skills = Yii::$app->request->post('skills', []);
            $model->education = Yii::$app->request->post('UserEducation', []);
            $model->experience = Yii::$app->request->post('UserExperience', []);
            $model->generateAuthKey();
            $profile->load(Yii::$app->request->post());
            if (\yii\base\Model::validateMultiple([$model, $profile])) {
                if ($model->save()) {
                    $profile->uid = $model->id;
                    $profile->save(false);
                    if (!empty($submit_skills)) {
                        foreach ($submit_skills as $skill) {
                            if (in_array($skill, $user_skills)) {
                                unset($user_skills[$skill]);
                            } else {
                                $user_skill = new \common\models\UserSkill;
                                $user_skill->skill_id = $skill;
                                $user_skill->uid = $model->id;
                                $user_skill->save();
                            }
                        }
                        \common\models\UserSkill::deleteAll(['and', ['skill_id' => array_values($user_skills)], ['uid' => $model->id]]);
                    } else {
                        \common\models\UserSkill::deleteAll(['and', ['skill_id' => array_values($user_skills)], ['uid' => $model->id]]);
                    }
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Profile updated successfully'));
                    $this->updateProfileComplete($model->id);
                    return $this->redirect(['/profile/view', 'id' => $model->id, 'name' => $model->fullname]);
                }
            }
        }

        return $this->render('editProfile', ['model' => $model, 'profile' => $profile, 'countries' => $countries, 'user_skills' => $user_skills, 'skills' => $skills]);
    }

    /**
     * Change user password 
     * @return type
     */
    public function actionChangePassword() {
        $user = $this->findModel(Yii::$app->user->id);
        $model = new \app\modules\api\models\ChangePassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $validat_pass = Yii::$app->security->validatePassword($model->old_password, $user->password_hash);
            if ($validat_pass) {
                $user->setPassword($model->new_password);
                $user->save(false);
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Password updated successfully'));
                return $this->redirect(['/profile/view', 'id' => $user->id, 'name' => $user->fullname]);
            } else {
                $model->addError('old_password', Yii::t('app', 'Old password is invalid'));
            }
        }
        return $this->render('changePassowrd', ['model' => $model, 'user' => $user]);
    }

    /**
     * Get all events created by user  
     * @return type
     */
    public function actionEvents() {
        $user = $this->findModel(Yii::$app->user->id);
        $events = \common\models\Event::find()->where(['uid' => $user->id])->notDeleted();
        $data_provider = new ActiveDataProvider([
            'query' => $events
        ]);
        return $this->render('events', ['user' => $user, 'events' => $data_provider]);
    }

    /**
     * Get all complaints created by user  
     * @return type
     */
    public function actionComplaints() {
        $user = $this->findModel(Yii::$app->user->id);
        $complaints = \common\models\Complaint::find()->where(['uid' => $user->id])->active();
        $data_provider = new ActiveDataProvider([
            'query' => $complaints
        ]);
        return $this->render('complaints', ['user' => $user, 'complaints' => $data_provider]);
    }

    /**
     * Get all initiatives created by user  
     * @return type
     */
    public function actionInitiatives() {
        $user = $this->findModel(Yii::$app->user->id);
        $initiatives = \common\models\Initiative::find()->where(['uid' => $user->id])->active();
        $data_provider = new ActiveDataProvider([
            'query' => $initiatives
        ]);
        return $this->render('initiatives', ['user' => $user, 'initiatives' => $data_provider]);
    }

    /**
     * Add new event 
     * @return type
     */
    public function actionAddEvent() {
        $user = $this->findModel(Yii::$app->user->id);
        $model = new \common\models\Event;
        $model->scenario = 'insert';
        $governorates = \yii\helpers\ArrayHelper::map(\common\models\Governorate::find()->notDeleted()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->uid = Yii::$app->user->id;
            $model->status = \common\models\Event::STATUS_NOT_ACTIVE;
            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New event added successfully'));
                return $this->redirect(['/profile/events']);
            }
        }
        return $this->render('eventForm', ['user' => $user, 'governorates' => $governorates, 'model' => $model]);
    }

    /**
     * Add new event 
     * @return type
     */
    public function actionEditEvent($id) {
        $user = $this->findModel(Yii::$app->user->id);
        $model = \common\models\Event::findOne($id);
        if (Yii::$app->user->can('updateOwnComplaint', ['complaint' => $model])) {
            $model->scenario = 'update';
            $governorates = \yii\helpers\ArrayHelper::map(\common\models\Governorate::find()->notDeleted()->all(), 'id', 'name');
            if ($model->load(Yii::$app->request->post())) {
                $model->uid = Yii::$app->user->id;
                $model->status = \common\models\Event::STATUS_NOT_ACTIVE;
                if ($model->validate()) {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Event edited successfully'));
                    return $this->redirect(['/profile/events']);
                }
            }
            return $this->render('eventForm', ['user' => $user,
                        'governorates' => $governorates,
                        'model' => $model]);
        } else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Add new complaint 
     * @return type
     */
    public function actionAddComplaint() {
        $user = $this->findModel(Yii::$app->user->id);
        $model = new \common\models\Complaint;
        $model->scenario = 'insert';
        $governorates = \yii\helpers\ArrayHelper::map(\common\models\Governorate::find()->notDeleted()->all(), 'id', 'name');
        $indicators = \common\models\Indicator::find()->all();
        $cities = \yii\helpers\ArrayHelper::map(\common\models\City::find()->notDeleted()->all(), 'id', 'name');
        $districts = \yii\helpers\ArrayHelper::map(\common\models\District::find()->notDeleted()->all(), 'id', 'name');
        $map = $this->getMap();

        if ($model->load(Yii::$app->request->post())) {
            $map = $this->getMap($model->lat, $model->long);
            $model->uid = Yii::$app->user->id;
            $model->status = \common\models\Complaint::STATUS_NOT_ACTIVE;
            $model->verfied = \common\models\Complaint::STATUS_NOT_VERFIED;
            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New complaint added successfully'));
                return $this->redirect(['/profile/complaints']);
            }
        }
        return $this->render('_complaintForm', [
                    'user' => $user,
                    'indicators' => $indicators,
                    'model' => $model,
                    'governorates' => $governorates,
                    'map' => $map,
                    'cities' => $cities,
                    'districts' => $districts,
        ]);
    }

    /**
     * Updates an existing Complaint model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id                    if (!empty($user_skills)) {

      }
     * @return mixed
     */
    public function actionEditComplaint($id) {
        $user = $this->findModel(Yii::$app->user->id);
        $model = \common\models\Complaint::findOne($id);
        if (Yii::$app->user->can('updateOwnComplaint', ['complaint' => $model])) {
            $model->scenario = 'update';
            $map = $this->getMap($model->lat, $model->long);
            $governorates = \yii\helpers\ArrayHelper::map(\common\models\Governorate::find()->notDeleted()->all(), 'id', 'name');
            $cities = \yii\helpers\ArrayHelper::map(\common\models\City::find()->notDeleted()->all(), 'id', 'name');
            $districts = \yii\helpers\ArrayHelper::map(\common\models\District::find()->notDeleted()->all(), 'id', 'name');
            $indicators = \common\models\Indicator::find()->all();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Complaint edited successfully'));
                    return $this->redirect(['/profile/complaints']);
                }
            }
            return $this->render('_complaintForm', [
                        'model' => $model,
                        'governorates' => $governorates,
                        'indicators' => $indicators,
                        'map' => $map,
                        'cities' => $cities,
                        'districts' => $districts,
            ]);
        } else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Add new initiative 
     * @return type
     */
    public function actionAddInitiative($id, $title) {
        $user = $this->findModel(Yii::$app->user->id);
        $model = new \common\models\Initiative;
        $model->scenario = 'insert';
        $governorates = \yii\helpers\ArrayHelper::map(\common\models\Governorate::find()->notDeleted()->all(), 'id', 'name');
        $cities = \yii\helpers\ArrayHelper::map(\common\models\City::find()->notDeleted()->all(), 'id', 'name');
        $districts = \yii\helpers\ArrayHelper::map(\common\models\District::find()->notDeleted()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->uid = Yii::$app->user->id;
            $model->complaint_id = $id;
            $model->status = \common\models\Complaint::STATUS_NOT_ACTIVE;
            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New Initiative added successfully'));
                return $this->redirect(['/profile/initiatives']);
            }
        }
        return $this->render('initiativeForm', ['user' => $user,
                    'model' => $model,
                    'governorates' => $governorates,
                    'cities' => $cities,
                    'districts' => $districts,
        ]);
    }

    /**
     * edit initiative 
     * @return type
     */
    public function actionEditInitiative($id) {
        $user = $this->findModel(Yii::$app->user->id);
        $model = \common\models\Initiative::findOne($id);
        $model->scenario = 'update';
        if (Yii::$app->user->can('updateOwnComplaint', ['complaint' => $model])) {
            $governorates = \yii\helpers\ArrayHelper::map(\common\models\Governorate::find()->notDeleted()->all(), 'id', 'name');
            $cities = \yii\helpers\ArrayHelper::map(\common\models\City::find()->notDeleted()->all(), 'id', 'name');
            $districts = \yii\helpers\ArrayHelper::map(\common\models\District::find()->notDeleted()->all(), 'id', 'name');
            if ($model->load(Yii::$app->request->post())) {
                $model->uid = Yii::$app->user->id;
                $model->complaint_id = $id;
                $model->status = \common\models\Complaint::STATUS_NOT_ACTIVE;
                if ($model->validate()) {
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'New Initiative added successfully'));
                    return $this->redirect(['/profile/initiatives']);
                }
            }
            return $this->render('initiativeForm', ['user' => $user,
                        'model' => $model,
                        'governorates' => $governorates,
                        'cities' => $cities,
                        'districts' => $districts,
            ]);
        } else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * remove complaint
     * @param type $id
     */
    public function actionRemoveComplaint() {
        if (\Yii::$app->request->isAjax) {
            $user = $this->findModel(Yii::$app->user->id);
            $id = \Yii::$app->request->post('id');
            $model = \common\models\Complaint::findOne($id);
            if ($model && Yii::$app->user->can('updateOwnComplaint', ['complaint' => $model])) {
                $model->df = \common\models\Complaint::DELETED;
                $model->save();
                return json_encode(['success' => 1]);
            }
        }
        return json_encode(['success' => 0]);
    }

    /**
     * remove event
     * @param type $id
     */
    public function actionRemoveEvent() {
        if (\Yii::$app->request->isAjax) {
            $user = $this->findModel(Yii::$app->user->id);
            $id = \Yii::$app->request->post('id');
            $model = \common\models\Event::findOne($id);
            if ($model && Yii::$app->user->can('updateOwnComplaint', ['complaint' => $model])) {
                $model->df = \common\models\Event::DELETED;
                $model->save();
                return json_encode(['success' => 1]);
            }
        }
        return json_encode(['success' => 0]);
    }

    /**
     * remove initiative
     * @param type $id
     */
    public function actionRemoveInitiative() {
        if (\Yii::$app->request->isAjax) {
            $user = $this->findModel(Yii::$app->user->id);
            $id = \Yii::$app->request->post('id');
            $model = \common\models\Initiative::findOne($id);
            if ($model && Yii::$app->user->can('updateOwnComplaint', ['complaint' => $model])) {
                $model->df = \common\models\Initiative::DELETED;
                $model->save();
                return json_encode(['success' => 1]);
            }
        }
        return json_encode(['success' => 0]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::find()->with(['profile', 'skill', 'education', 'experience'])->where(['id' => $id])->active()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getMap($lat = 31.9622689, $lng = 35.9305726) {
        if (empty($lat) || empty($lng)) {
            $lat = 31.9622689;
            $lng = 35.9305726;
        }
        $coord = new LatLng(['lat' => $lat, 'lng' => $lng]);
        $map = new Map([
            'center' => $coord,
            'zoom' => 12,
            'scrollwheel' => false,
        ]);
        $map->width = '100%';
        // Lets add a marker now
        $marker = new Marker([
            'position' => $coord,
            'title' => 'Complaint location',
//            'icon' => \yii\helpers\Url::to('@images' . '/favicon.ico'),
            'draggable' => true,
        ]);
        #add event to map
        $event = new Event(['trigger' => 'dragend', 'js' => "$('#complaint-lat').val(event.latLng.lat());$('#complaint-long').val(event.latLng.lng());"]);
        $marker->addEvent($event);

        $map->addOverlay($marker);

        return $map;
    }

    function updateProfileComplete($id) {
        $user = User::findOne($id);
        if ($user) {
            if ($user->education || $user->experience || $user->skill) {
                $user->profile_completed = User::PROFILE_COMPLETED;
            } else {
                $user->profile_completed = User::PROFILE_NOT_COMPLETED;
            }
            $user->save(false);
        }
    }

}
