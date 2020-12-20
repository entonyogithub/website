<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\api\helpers;

use Yii;
use yii\helpers\Url;
use yii\base\InvalidConfigException;

/**
 * Collection of useful helper functions for Yii Applications
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 *
 */
class ApiHelper {

    Const STATUS_SUCCESS = 1;
    Const STATUS_FAIL = 0;

    public static function setErrorResponse($success = self::STATUS_FAIL, $messages = array()) {
        $header_lang = \Yii::$app->request->headers->get('lang') ? \Yii::$app->request->headers->get('lang') : 'en';
        $arr = [];
        $arr['success'] = $success;
        $arr['errors'] = [];
        if (!empty($messages)) {
            foreach ($messages as $key => $message) {
                $keys = explode("-", $key);
                $key = end($keys);
                if (is_array($message)) {
                    foreach ($message as $row) {
                        $arr['errors'][$key] = Yii::t('app', $row, [], $header_lang);
                    }
                } else {
                    $arr['errors'][$key] = Yii::t('app', $message, [], $header_lang);
                }
            }
        }
        //Yii::t('base', 'Save', [], 'fr');
        return $arr;
    }

    public function getTokenFromHeader($authHeader) {

        preg_match("/^Bearer\\s+(.*?)$/", $authHeader, $matches);
        if (isset($matches[1]))
            return $matches[1];
        return '';
    }

    /**
     * Generate custom array from user fields 
     * @param Object $user
     * @param string $token
     * @param int $no_token
     * @return type
     */
    public static function getUserInfo($user, $add_token = 0, $token = null) {
        $arr = [];
        $arr['email'] = $user->email;
        if ($add_token)
            $arr['token'] = $token;
        $arr['first_name'] = $user->userProfile->first_name;
        $arr['last_name'] = $user->userProfile->last_name;
        $arr['class_id'] = null;
        $arr['duration'] = null;
        $student_join_class = \common\models\StudentJoinedClass::find()->where(['uid' => $user->id])->one();
        if ($student_join_class) {
            $arr['class_id'] = $student_join_class->class_id;
            $arr['duration'] = $student_join_class->class->recording_duration*60;
             $arr['listening_duration'] = $student_join_class->class->listening_duration*60;
        }
        return $arr;
    }

    public static function getListeningInfo($listening) {
        $arr['id'] = $listening->id;
        $arr['title'] = $listening->title;
        $arr['file'] = Url::to($listening->getUploadUrl('file'), true);
         $arr['date'] = self::formatDate($listening->created_at);
        return $arr;
    }

    /**
     * Get user object from token
     * @param Object $product
     * @return boolean
     */
    public static function getUserFromToken($oauth_validation = true) {
        $header = Yii::$app->request->getHeaders()->get('Authorization');
        $accessToken = ApiHelper::getTokenFromHeader($header);
        if (!empty($accessToken)) {
            if ($oauth_validation) {
                $oauth2 = \Yii::$app->getModule('oauth2');
                $data = $oauth2->getServer()->getAccessTokenData(\OAuth2\Request::createFromGlobals());
                if ($data) {
                    $accessToken = $data['access_token'];
                    $user = \common\models\User::findIdentityByAccessToken($accessToken);
                    return $user;
                }
            } else {
                $user = \common\models\User::findIdentityByAccessToken($accessToken);
                if ($user)
                    return $user;
            }
        }
        return null;
    }

    public static function formatDate($date) {
        return Yii::$app->formatter->asDatetime($date);
    }

}
