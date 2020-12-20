<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "class".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $title
 * @property integer $total_number_of_lectures
 * @property integer $taken_lectures
 * @property integer $total_number_of_recording
 * @property integer $total_number_of_listening
 * @property integer $listening_duration
 * @property integer $recording_duration
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 *
 * @property User $u
 */
class StudentClass extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'class';
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
            ['taken_lectures', 'default', 'value' => 0],
            [['title', 'total_number_of_lectures', 'total_number_of_recording', 'total_number_of_listening', 'listening_duration', 'recording_duration', 'minimum_uploads', 'minimum_listening','iam_in_listenings','iam_in_uploads'], 'required'],
            [['total_number_of_lectures', 'total_number_of_recording', 'total_number_of_listening', 'listening_duration', 'recording_duration','show_payment','enable_iam_in'], 'integer'],
            [['uid', 'total_number_of_lectures', 'taken_lectures', 'total_number_of_recording', 'total_number_of_listening', 'listening_duration', 'recording_duration', 'created_at', 'updated_at', 'df'], 'integer'],
            [['title','rating'], 'string', 'max' => 255],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']]
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
            'title' => 'Title',
            'total_number_of_lectures' => 'Total Number Of Lectures',
            'taken_lectures' => 'Taken Lectures',
            'total_number_of_recording' => 'Total Number Of Recording',
            'total_number_of_listening' => 'Total Number Of Listening',
            'iam_in_listenings'=>'I am in total listentings',
             'iam_in_uploads'=>'I am in total recordings',
            'enable_iam_in'=>'Enable i am in option',
            'rating' => 'Rating',
            'minimum_listening' => "Minimum number of recordings",
            'minimum_uploads' => "Minimum number of listenings",
            'listening_duration' => 'Listening Duration',
            'recording_duration' => 'Recording Duration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new StudentClassQuery(get_called_class());
    }

    public function getLecturesVal() {
        return $this->taken_lectures . " / " . $this->total_number_of_lectures;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

}

class StudentClassQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => StudentClass::NOT_DELETED]);
    }

}
