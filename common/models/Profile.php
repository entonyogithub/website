<?php

namespace common\models;

use Yii;
use mohorev\file\UploadImageBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $first_name
 * @property string $last_name
 * @property integer $gender
 * @property string $date_of_birth
 *
 * @property User $u
 */
class Profile extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => UploadImageBehavior::className(),
                'attribute' => 'photo',
                'scenarios' => ['insert', 'update'],
                'generateNewName' => true,
                'instanceByName' => false,
                'createThumbsOnSave' => false,
                'path' => '@frontend/web/upload/original',
                'url' => '@fronturl/uploaded/original',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['uid'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['name', 'mobile'], 'filter', 'filter' => 'trim'],
            [['name', 'mobile','date_of_birth'], 'required'],
            [['name', 'mobile'], 'string', 'max' => 255],
            ['photo', 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['update','insert']],
            [['date_of_birth'], 'required'],
            ['date_of_birth', 'date', 'format' => 'yyyy-mm-dd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => Yii::t('app','Full name'),
            'mobile' => Yii::t('app','Mobile'),
            'date_of_birth' => Yii::t('app','Date Of Birth'),
            'photo' => Yii::t('app','Photo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

}
