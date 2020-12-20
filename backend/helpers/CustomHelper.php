<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\helpers;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Collection of useful helper functions for Yii Applications
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 *
 */
class CustomHelper {

    public static function getNotifications() {
        $arr = [];
        return $arr;
    }

    /**
     * Get image options 
     * @param type $isNew
     * @param type $field
     * @param type $model
     * @return array
     */
    public static function getImageOptions($model, $field, $add_remove = false) {
        $options = [];
        $options = [
            'showPreview' => false,
            'showUpload' => false,
            'showRemove' => $add_remove ? true : false,
            'overwriteInitial' => true
        ];
        if (!$model->isNewRecord && $model->$field) {
            $options = [
                'showPreview' => false,
                'showUpload' => false,
                'showRemove' => $add_remove ? true : false,
                'initialCaption' => $model->$field,
                'overwriteInitial' => $add_remove ? true : false,
            ];
        }
        return $options;
    }

    public static function getStartEndDates() {
        if (date('D') == "Thu") {
            $start_date = strtotime('last thursday');
            $end_date = time();
        } else {
            $start_date = strtotime('last thursday');
            $end_date = strtotime('next thursday');
        }
        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }

    public static function imageStyle($image, $style = 'w160x160') {
        if (isset(Yii::$app->params['image'][$style]['url']))
            return Url::to(Yii::$app->params['image'][$style]['url']) . '/' . $image;
        return '';
    }

    public static function setErrorResponse($messages = array()) {
        $arr = array();
        if (!empty($messages)) {
            foreach ($messages as $message) {
                if (is_array($message)) {
                    foreach ($message as $row) {
                        $arr[] = Yii::t('app', $row);
                    }
                } else {
                    $arr[] = Yii::t('app', $message);
                }
            }
        }
        return $arr;
    }

}
