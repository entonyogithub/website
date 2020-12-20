<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \common\models\User;

/**
 * Login form
 */
class ImportForm extends Model {

    public $file;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['file'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'file' => Yii::t('app', 'File'),
        ];
    }

}
