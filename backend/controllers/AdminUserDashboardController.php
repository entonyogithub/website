<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use wapmorgan\MediaFile\MediaFile;

/**
 * Site controller
 */
class AdminUserDashboardController extends Controller {

    public function actionIndex() {
        $options = [
            "id" => "file",
            'language' => 'en',
            'pluginOptions' => [
                'showUpload' => false,
                'showRemove' => false,
                'showCancel' => false,
                'browseClass' => 'btn btn-default btn-block',
                'browseLabel' => Yii::t('app', 'Add file'),
                'uploadLabel' => Yii::t('app', 'Upload'),
                'removeLabel' => Yii::t('app', 'Remove'),
            ],
//            'options' => ['accept' => 'audio/wav,audio/mp3,audio/mpeg,audio/x-wav',],
        ];
        $upload = new \common\models\StudentUpload();
        $upload->scenario = "insert";
        $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => \Yii::$app->user->id])->one();
        if ($student_join_class) {
            $iamInForm = new \common\models\IamInMember();
            $student_uploads = new \yii\data\ActiveDataProvider([
                'query' => \common\models\StudentUpload::find()->where(['class_id' => $student_join_class ? $student_join_class->class_id : 0])->weekly()->orderBy('created_at DESC'),
                'pagination' => false
            ]);
            $user_uploads_count = \common\models\StudentUpload::find()->where(['uid' => \Yii::$app->user->id])->weekly()->count();
            $user_listening_count = \common\models\StudentListening::find()->where(['uid' => \Yii::$app->user->id])->weekly()->count();
            $teacher_uploads = new \yii\data\ActiveDataProvider([
                'query' => \common\models\TeacherUpload::find()->where(['class_id' => $student_join_class ? $student_join_class->class_id : 0])->notDeleted()->orderBy('created_at DESC'),
                'pagination' => false
            ]);
            $payment_count = \common\models\UserPayment::find()->where(['uid' => \Yii::$app->user->id])->andWhere('FROM_UNIXTIME(created_at) >= LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL 1 MONTH and FROM_UNIXTIME(created_at) < LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY')->count();
            $IamInMember_exist = \common\models\IamInMember::find()->where(['uid' => \Yii::$app->user->id, 'class_id' => $student_join_class->class_id])->weekly()->exists();
            if ($iamInForm->load(\Yii::$app->request->post())) {
                if (!$IamInMember_exist) {
                    $iamInForm->listening_count = $user_listening_count;
                    $iamInForm->recording_count = $user_uploads_count;
                    $submit = \Yii::$app->request->post('submit-btn');
                    $iamInForm->coming = \common\models\Enum::ANSWER_YES;
                    if ($submit == 'no') {
                        $iamInForm->coming = \common\models\Enum::ANSWER_NO;
                    }
                    if ($iamInForm->save()) {
                        $this->redirect(['index']);
                    }
                }
            }
            return $this->render('index', [
                        'options' => $options,
                        'upload' => $upload,
                        'student_uploads' => $student_uploads,
                        'class' => $student_join_class,
                        'user_uploads_count' => $user_uploads_count,
                        'user_listening_count' => $user_listening_count,
                        'teacher_uploads' => $teacher_uploads,
                        'payment_count' => $payment_count,
                        'iamInForm' => $iamInForm,
                        'IamInMember_exist' => $IamInMember_exist
            ]);
        } else {
            return $this->render('noClass');
        }
    }

    public function actionUpload() {
        if (\Yii::$app->request->isAjax) {
            $arr = ['success' => 1, 'error' => ''];
            $file_path = $_FILES['file']['tmp_name'];
            $media = MediaFile::open($file_path);
            $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => \Yii::$app->user->id])->one();
            if ($student_join_class) {
                $class_id = $student_join_class->class_id;
                $duration = $student_join_class->class->recording_duration;
                if ($media->isAudio()) {
                    $audio = $media->getAudio();
                    if ($duration && $audio->getLength() > $duration * 60) {
                        $student_upload = new \common\models\StudentUpload();
                        $student_upload->scenario = 'insert';
                        $student_upload->instanceByName = true;
                        $student_upload->uid = \Yii::$app->user->id;
                        $student_upload->class_id = $class_id;
                        if ($student_upload->save()) {
                            $arr['success'] = 1;
                        }
                    } else {
                        $arr['success'] = 0;
                        $arr['error'] = ["Audio length must be at least $duration minutes"];
                    }
                } else {
                    $arr['success'] = 0;
                    $arr['error'] = ['Not supported file type only audio files can be uploaded(WAV/MP3)'];
                }
            }


            echo json_encode($arr);
        }
    }

    public function actionListenComplete() {

        if (\Yii::$app->request->isAjax) {
            $arr = ['success' => 0, 'error' => ''];
            $class_id = \Yii::$app->request->post('class_id', null);
            $upload_id = \Yii::$app->request->post('upload_id', null);
            $user_id = \Yii::$app->user->id;

            if ($class_id && $upload_id) {
                $exist_record = \common\models\StudentListening::find()->where(['uid' => $user_id, 'class_id' => $class_id])->andWhere("FROM_UNIXTIME(created_at,'%Y-%m-%d') = CURDATE()")->count();
                if ($exist_record == 0) {
                    $student_listening = new \common\models\StudentListening();
                    $student_listening->uid = $user_id;
                    $student_listening->class_id = $class_id;
                    $student_listening->upload_id = $upload_id;
                    if ($student_listening->save()) {
                        $arr['success'] = 1;
                    }
                }
            }
            echo json_encode($arr);
        }
    }

    public function actionProfile() {
        $user = \common\models\User::find()->where(['id' => \Yii::$app->user->id])->active()->one();
        return $this->render('profile', [
                    'model' => $user,
        ]);
    }

    public function actionAssignments() {
        $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => \Yii::$app->user->id])->one();
        $assignments = new \yii\data\ActiveDataProvider([
            'query' => \common\models\Assignment::find()->where(['class_id' => $student_join_class ? $student_join_class->class_id : 0])->notDeleted()->orderBy('created_at DESC'),
            'pagination' => false
        ]);
        return $this->render('assignment', [
                    'assignments' => $assignments,
        ]);
    }

    public function actionPayments() {
        $payments = new \yii\data\ActiveDataProvider([
            'query' => \common\models\UserPayment::find()->where(['uid' => \Yii::$app->user->id])->orderBy('created_at DESC'),
            'pagination' => false
        ]);
        return $this->render('payments', [
                    'payments' => $payments,
        ]);
    }

    public function actionSyllabusRecords() {
        $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => \Yii::$app->user->id])->one();
        $records = new \yii\data\ActiveDataProvider([
            'query' => \common\models\ClassSyllabus::find()->where(['class_id' => $student_join_class ? $student_join_class->class_id : 0])->orderBy('created_at DESC'),
            'pagination' => false
        ]);
        return $this->render('_records', [
                    'records' => $records,
        ]);
    }

    public function actionTest() {
        return $this->render('test');
    }

    public function actionBestStudents() {
        $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => \Yii::$app->user->id])->one();
        $students_arr = [];
        if ($student_join_class) {
            $students = \common\models\StudentJoinedClass::find()->where(['class_id' => $student_join_class->class_id])->all();
            if ($students) {
                foreach ($students as $student) {
                    $user_uploads_count = \common\models\StudentUpload::find()->where(['uid' => $student->uid])->weekly()->count();
                    $user_listening_count = \common\models\StudentListening::find()->where(['uid' => $student->uid])->weekly()->count();
                    if ($user_uploads_count >= $student_join_class->class->total_number_of_recording && $user_listening_count >= $student_join_class->class->total_number_of_listening) {
                        $students_arr[] = [
                            'id' => $student->user->id,
                            'name' => $student->user->userProfile->first_name . " " . $student->user->userProfile->last_name,
                            'age' => $student->user->userProfile->age,
                        ];
                    }
                }
            }
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'models' => $students_arr,
        ]);
        return $this->render('topStudents', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Send message to user
     * @return type
     */
    public function actionMessages() {
        $user_id = Yii::$app->user->id;
        \common\models\Message::updateAll(['read' => \common\models\Enum::ANSWER_YES], ['uid' => $user_id, 'read' => \common\models\Enum::ANSWER_NO, 'type' => \common\models\Message::MESSAGE_ADMIN]);
        $messages = \common\models\Message::find()->where(['uid' => $user_id])->orderBy('created_at ASC')->all();
        $message = new \backend\models\SendMessage();
        if ($message->load(Yii::$app->request->post())) {
            if ($message->validate()) {
                $new_message = new \common\models\Message();
                $new_message->uid = $user_id;
                $new_message->message = $message->message;
                $new_message->type = \common\models\Message::MESSAGE_USER;
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

    public function actionAttendance() {
        $records = new \yii\data\ActiveDataProvider([
            'query' => \common\models\AttendanceLog::find()->where(['uid'=> \Yii::$app->user->id])->orderBy('created_at DESC'),
        ]);
        return $this->render('log', [
                    'records' => $records,
        ]);
    }

}
