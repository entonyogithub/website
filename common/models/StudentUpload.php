<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use mohorev\file\UploadImageBehavior;

/**
 * This is the model class for table "student_upload".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $class_id
 * @property string $file
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class StudentUpload extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'student_upload';
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
            [['uid', 'class_id'], 'required'],
            [['uid', 'class_id', 'created_at', 'updated_at', 'df'], 'integer'],
            ['file', 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'class_id' => 'Class ID',
            'file' => 'File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new StudentUploadQuery(get_called_class());
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

    public function getUploadUrl($attribute){
        return \Yii::getAlias("@fronturl/upload/original") . '/' . $this->$attribute;
        
    }
}

class StudentUploadQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => StudentUpload::NOT_DELETED]);
    }

    public function weekly() {
        $dates = \backend\helpers\CustomHelper::getStartEndDates();
        return $this->andWhere(['and',['df' => StudentUpload::NOT_DELETED],['between','created_at',$dates['start_date'],$dates['end_date']]]);
    }

}
