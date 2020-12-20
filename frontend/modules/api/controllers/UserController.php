<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\helpers\ApiHelper;
use yii\helpers\ArrayHelper;
use springdev\yii2\oauth2mysqlserver\filters\ErrorToExceptionFilter;
use springdev\yii2\oauth2mysqlserver\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use \yii\filters\VerbFilter;
use \common\models\User;
use \app\modules\api\models\ChangePassword;
use app\modules\api\helpers\CustomResponseErrors;
use wapmorgan\MediaFile\MediaFile;

class UserController extends \yii\rest\Controller {

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'profile' => ['get'],
                        ],
                    ],
                    'authenticator' => [
                        'class' => CompositeAuth::className(),
                        'except' => ['login', ''],
                        'authMethods' => [
                            ['class' => HttpBearerAuth::className()],
                            ['class' => QueryParamAuth::className(), 'tokenParam' => 'accessToken'],
                        ]
                    ],
                    'exceptionFilter' => [
                        'class' => ErrorToExceptionFilter::className()
                    ],
        ]);
    }

    /**
     * Login user through api
     * @return type
     */
    public function actionLogin() {

        $return_arr = [];
        $return_arr['success'] = ApiHelper::STATUS_FAIL;
        $user = User::find()->where(['username' => Yii::$app->request->post('username', ''), 'role' => 'Users'])->active()->one();
        $device_token = Yii::$app->request->post('device_token');
        if ($user) {
            $oauth2 = \Yii::$app->getModule('oauth2');
            $_POST['grant_type'] = 'password';
            $response = $oauth2->getServer()->handleTokenRequest();
            $token = '';
            if ($response->isSuccessful()) {
                $data = $response->getParameters();
                $token = $data['access_token'];
                $user = \common\models\User::findIdentityByAccessToken($token);
//                $this->addDeviceToken($user->id, $device_token);
                $return_arr['success'] = ApiHelper::STATUS_SUCCESS;
                $return_arr['user'] = ApiHelper::getUserInfo($user, 1, $token);
            }
        } else {
            $return_arr = ApiHelper::setErrorResponse(ApiHelper::STATUS_FAIL, ["password" => CustomResponseErrors::INVALID_PASSWORD]);
        }

        return $return_arr;
    }

    /**
     * Load user profile data through api
     * @return type
     */
    public function actionProfile() {
        $return_arr = [];
        $return_arr['success'] = ApiHelper::STATUS_FAIL;
        $user = ApiHelper::getUserFromToken();
        if ($user) {
            $return_arr['success'] = ApiHelper::STATUS_SUCCESS;
            $return_arr['user'] = ApiHelper::getUserInfo($user);
        }
        return $return_arr;
    }

    /**
     * Load user profile data through api
     * @return type
     */
    public function actionUpload() {
        $return_arr = [];
        $return_arr['success'] = ApiHelper::STATUS_FAIL;
        $return_arr['errors'] = [];
        $user = ApiHelper::getUserFromToken();
        if ($user) {
            $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => $user->id])->one();
            if ($student_join_class) {
                $file = \yii\web\UploadedFile::getInstanceByName('file');
                if ($file) {
                    $name = uniqid();
                    $file_path = \Yii::getAlias("@frontend/web/upload/original") . '/' . $name . "." . $file->extension;
                    if ($file->saveAs($file_path)) {
                        $mp3_file_name = $name . ".mp3";
                        $full_path_mp3 = \Yii::getAlias("@frontend/web/upload/original") . '/' . $mp3_file_name;
                        $outPut = shell_exec("ffmpeg -i $file_path -ab 128 -b 1200 $full_path_mp3");
                        if (file_exists($full_path_mp3)) {
                            $class_id = $student_join_class->class_id;
                            $duration = $student_join_class->class->recording_duration;
                            $mp3_file = new \common\components\MP3File($full_path_mp3);
                            if (($mp3_file->getDuration() * 2 ) > ($duration * 60)) {
                                $student_upload = new \common\models\StudentUpload();
                                $student_upload->uid = $user->id;
                                $student_upload->class_id = $class_id;
                                $student_upload->file = $mp3_file_name;
                                if ($student_upload->save()) {
                                    $return_arr = ApiHelper::setErrorResponse(ApiHelper::STATUS_SUCCESS, []);
                                    unlink($file_path);
                                } else {
                                    $return_arr = ApiHelper::setErrorResponse(ApiHelper::STATUS_FAIL, \yii\bootstrap\ActiveForm::validate($student_upload));
                                }
                            } else {
                                unlink($file_path);
                                unlink($full_path_mp3);
                                $return_arr = ApiHelper::setErrorResponse(ApiHelper::STATUS_FAIL, ['file'=>"file size should be at least $duration mninute"]);
                            }
                        }
                    }
                }
            }
        }
        return $return_arr;
    }

    /**
     * Load user profile data through api
     * @return type
     */
    public function actionListenings() {
        $return_arr = [];
        $return_arr['success'] = ApiHelper::STATUS_SUCCESS;
        $return_arr['data'] = [];
        $user = ApiHelper::getUserFromToken();
        if ($user) {
            $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => $user->id])->one();
            if ($student_join_class) {
                $listenings = \common\models\TeacherUpload::find()->where(['class_id' => $student_join_class->class_id])->notDeleted()->orderBy('created_at DESC')->all();
                if ($listenings) {
                    foreach ($listenings as $listening) {
                        $return_arr['data'][] = ApiHelper::getListeningInfo($listening);
                    }
                }
            }
        }
        return $return_arr;
    }

    public function actionListeningComplete() {
        $return_arr = [];
        $return_arr['success'] = ApiHelper::STATUS_SUCCESS;
        $return_arr['data'] = [];
        $user = ApiHelper::getUserFromToken();
        if ($user) {
            $upload_id = \Yii::$app->request->post('upload_id', null);
            $class_id = \Yii::$app->request->post('class_id', null);
            $user_id = $user->id;
            if ($class_id && $upload_id) {
                $exist_record = \common\models\StudentListening::find()->where(['uid' => $user_id, 'class_id' => $class_id])->andWhere("FROM_UNIXTIME(created_at,'%Y-%m-%d') = CURDATE()")->count();
                if ($exist_record == 0) {
                    $student_listening = new \common\models\StudentListening();
                    $student_listening->uid = $user_id;
                    $student_listening->class_id = $class_id;
                    $student_listening->upload_id = $upload_id;
                    if ($student_listening->save()) {
                        $return_arr = ApiHelper::setErrorResponse(ApiHelper::STATUS_SUCCESS, []);
                    }
                }
            }
        }
        return $return_arr;
    }

    /**
     * Validate access token function
     * @param Object $server
     * @param Object $response
     * @param int $client_id
     * @param int $user_id
     * @return type
     */
    public function actionLogout() {
        $return_arr = [];
        $return_arr['success'] = ApiHelper::STATUS_FAIL;
        $user = ApiHelper::getUserFromToken();
        if ($user) {
            $tokens = \springdev\yii2\oauth2mysqlserver\models\OauthAccessTokens::find()->where(['user_id' => $user->id])->andWhere(['>', 'expires', time()])->all();
            if ($tokens) {
                foreach ($tokens as $token) {
                    $token->expires = time();
                    $token->save();
                }
            }
            $return_arr['success'] = ApiHelper::STATUS_SUCCESS; 
        }

        return $return_arr;
    }

    private function checkToGetToken($server, $response, $client_id, $user_id) {
        if ($response->isSuccessful()) {
            $response = $server->createAccessToken($client_id, $user_id);
            return $response['access_token'];
        }
    }

}
