<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\helpers;

use Yii;
use yii\helpers\Url;

/**
 * Collection of useful helper functions for Yii Applications
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 *
 */
class CustomUrl {

    public static function ViewProfile($user) {
        return Url::to(['/profile/view', 'id' => $user->id, 'name' => $user->fullname]);
    }

    private function formatTitle() {
        
    }

    public static function GetSettingValue($id) {
        $setting_val = \common\models\Setting::find()->where(['id'=>$id])->one();
        if($setting_val){
            if($setting_val->type == \common\models\Setting::TYPE_IMAGE){
                return Url::to('@original') . '/' . $setting_val->value;
            }else{
                return $setting_val->value;
            }
        }
        return '';
    }

}
