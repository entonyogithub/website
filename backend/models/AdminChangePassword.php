<?php

namespace backend\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AdminChangePassword extends Model {

    public $new_password;
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [

            [['new_password', 'confirm_password'], 'required'],
            [['new_password', 'confirm_password'], 'string', 'min' => 6],
            [['new_password'], 'compare', 'compareAttribute' => 'confirm_password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'new_password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
        ];
    }

}
