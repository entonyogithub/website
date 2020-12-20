<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $to_uid
 * @property string $message
 * @property integer $read
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class Message extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;
    //deleted or not flags
    const MESSAGE_ADMIN = 1;
    const MESSAGE_USER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'message';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['uid', 'type', 'message'], 'required'],
            [['message'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['uid', 'type', 'read', 'created_at', 'updated_at', 'df'], 'integer'],
            [['message'], 'string','max'=>500]
                ,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'to_uid' => 'To Uid',
            'message' => 'Message',
            'read' => 'Read',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new MessageQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

}

class MessageQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => Message::NOT_DELETED]);
    }

}
