<?php

namespace app\modules\api\models;

use common\models\User;
use common\models\Profile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class ChangePassword extends Model {

    public $old_password;
    public $new_password;
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [

            [['old_password', 'new_password', 'confirm_password'], 'required'],
            [['old_password', 'new_password', 'confirm_password'], 'string', 'min' => 6],
            [['new_password'], 'compare', 'compareAttribute' => 'confirm_password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'old_password' => Yii::t('app', 'Old password'),
            'new_password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
        ];
    }

}
