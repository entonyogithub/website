<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "iam_in_member".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $listening_count
 * @property integer $recording_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class IamInMember extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'iam_in_member';
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
            [['uid', 'class_id', 'listening_count', 'recording_count'], 'required'],
            [['uid', 'listening_count', 'recording_count', 'created_at', 'updated_at', 'df', 'coming'], 'integer']
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
            'listening_count' => 'Listening Count',
            'recording_count' => 'Recording Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new IamInMemberQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass() {
        return $this->hasOne(StudentClass::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

}

class IamInMemberQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => IamInMember::NOT_DELETED]);
    }

    public function weekly() {
        $dates = \backend\helpers\CustomHelper::getStartEndDates();
        return $this->andWhere(['and', ['df' => StudentUpload::NOT_DELETED], ['between', 'created_at', $dates['start_date'], $dates['end_date']]]);
    }

}
