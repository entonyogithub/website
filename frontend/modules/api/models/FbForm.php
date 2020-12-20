<?php

namespace app\modules\api\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class FbForm extends Model {

    public $email;
    public $fb_id;
    public $client_id;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            
            ['fb_id', 'filter', 'filter' => 'trim'],
            ['fb_id', 'required'],
            
            ['client_id', 'filter', 'filter' => 'trim'],
            ['client_id', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('app', 'Email'),
            'fb_id' => Yii::t('app', 'Facebook id'),
        ];
    }

}
