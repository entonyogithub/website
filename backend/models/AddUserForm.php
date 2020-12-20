<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \common\models\User;

/**
 * Login form
 */
class AddUserForm extends Model {

    public $uid;
    public $class_id;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['uid','class_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'uid' => "Username",
            'class_id' => "Class",
        ];
    }

    public function getTeachers() {
        return \yii\helpers\ArrayHelper::map(User::find()->where(['role' => "Teachers"])->all(), "id", "username");
    }

    public function getUsers() {
        return \yii\helpers\ArrayHelper::map(User::find()->where(['role' => "Users"])->orderBy('created_at DESC')->all(), "id", "username");
    }

}
