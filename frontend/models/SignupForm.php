<?php

namespace frontend\models;

use common\models\User;
use common\models\Profile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $email;
    public $password;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app','This email address has already been taken.')],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LdAcAkTAAAAAJ1xwKhlpQD0acXUixTYjF12EWdP']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

}
