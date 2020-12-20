<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \common\models\User;

/**
 * Login form
 */
class SendMessage extends Model {

    public $message;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['message'], 'required'],
            [['message'], 'string', 'max' => 500],
            [['message'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'message' => Yii::t('app', 'Message'),
        ];
    }

}
