<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use \yii\behaviors\TimestampBehavior;
use mohorev\file\UploadImageBehavior;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $name
 * @property string $value
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 *
 * @property User $u
 */
class Setting extends ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;
    //TYPES
    const TYPE_INEGER = 1;
    const TYPE_FLOAT = 2;
    const TYPE_TEXT = 3;
    const TYPE_STRING = 4;
    const TYPE_IMAGE = 5;
    //TYPES
    const HOME_IMAGE = 2;
    const ABOUT_IMAGE = 3;
    const FACEBOOK_LINK = 5;
    const TWITTER_LINK = 6;
    const GOOGLE_PLUs_LINK = 7;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadImageBehavior::className(),
                'attribute' => 'value',
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
    public static function tableName() {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['uid', 'type', 'name'], 'required'],
            ['value', 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_INEGER || $model->type == self::TYPE_TEXT || $model->type == self::TYPE_STRING;
                }],
            [['uid'], 'exist', 'targetClass' => '\common\models\User', 'targetAttribute' => 'id', 'message' => Yii::t('app', 'User not found')],
            [['uid', 'type', 'created_at', 'updated_at', 'df'], 'integer'],
            ['value', 'match', 'pattern' => '/[a-zA-Z]/', 'when' => function($model) {
                    return $model->type == self::TYPE_TEXT || $model->type == self::TYPE_STRING;
                }, 'whenClient' => "function(attribute, value) {
                            if($('#setting-type').val() == " . self::TYPE_TEXT . " || $('#setting-type').val() == " . self::TYPE_TEXT . ")
                              return true;
                          }"],
            ['value', 'integer', 'when' => function($model) {
                    return $model->type == self::TYPE_INEGER;
                }, 'whenClient' => "function(attribute, value) {
                              return $('#setting-type').val() == " . self::TYPE_INEGER . ";
                          }"],
            ['value', 'image', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert'], 'when' => function($model) {
            return $model->type == self::TYPE_IMAGE;
        }],
            ['value', 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['update'], 'when' => function($model) {
            return $model->type == self::TYPE_IMAGE;
        }],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'Uid'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'df' => Yii::t('app', 'Df'),
        ];
    }

    public static function find() {

        return new SettingQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public static function itemAlias($type = '', $index = null) {
        $arr = [
            'type' => [
                self::TYPE_INEGER => 'integer',
                self::TYPE_FLOAT => 'float',
                self::TYPE_TEXT => 'text',
                self::TYPE_STRING => 'string',
                self::TYPE_IMAGE => 'image',
            ],
        ];
        if (isset($index))
            return isset($arr[$type][$index]) ? $arr[$type][$index] : false;
        else
            return isset($arr[$type]) ? $arr[$type] : false;
    }

}

class SettingQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => Setting::NOT_DELETED]);
    }

}
