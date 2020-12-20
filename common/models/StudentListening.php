<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
/**
 * This is the model class for table "student_listening".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $class_id
 * @property integer $upload_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class StudentListening extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'student_listening';
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
            [['uid', 'class_id', 'upload_id'], 'required'],
            [['uid', 'class_id', 'upload_id', 'created_at', 'updated_at'], 'integer'],
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
            'upload_id' => 'Upload ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function find() {

        return new StudentListeningQuery(get_called_class());
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

    public function getUpload() {
        return $this->hasOne(TeacherUpload::className(), ['id' => 'upload_id']);
    }

}

class StudentListeningQuery extends ActiveQuery {

    public function weekly() {
        $dates = \backend\helpers\CustomHelper::getStartEndDates();
        return $this->andWhere(['between', 'created_at', $dates['start_date'], $dates['end_date']]);
    }

}
