<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "attendance_log".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $start_titme
 * @property string $end_time
 * @property string $duration
 * @property string $date
 * @property integer $created_at
 * @property integer $updated_at
 */
class AttendanceLog extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'attendance_log';
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
            [['uid', 'start_titme', 'end_time', 'duration', 'date'], 'required'],
            [['uid', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['start_titme', 'end_time', 'duration'], 'string', 'max' => 11],
            ['date', 'date', 'format' => 'yyyy-mm-dd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'Username',
            'start_titme' => 'Start Titme',
            'end_time' => 'End Time',
            'duration' => 'Duration',
            'date' => 'Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

}
