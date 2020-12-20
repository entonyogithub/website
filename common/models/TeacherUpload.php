<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use mohorev\file\UploadImageBehavior;

/**
 * This is the model class for table "teacher_upload".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $class_id
 * @property string $title
 * @property string $type
 * @property string $file
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class TeacherUpload extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'teacher_upload';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
            [
                'class' => UploadImageBehavior::className(),
                'attribute' => 'file',
                'scenarios' => ['insert', 'update'],
                'generateNewName' => true,
                'instanceByName' => false,
                'createThumbsOnSave' => false,
                'path' => '@frontend/web/upload/original',
                'url' => '@fronturl/upload/original',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'type', 'class_id'], 'required'],
            [['uid', 'class_id', 'created_at', 'updated_at', 'df', 'type'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => 'wav,mp3', 'on' => ['insert'], 'when' => function($query) {
                    return $query->type == Enum::TYPE_AUDIO;
                }],
            ['file', 'file', 'skipOnEmpty' => false, 'extensions' => 'doc,docx,pdf', 'on' => ['insert'], 'when' => function($query) {
                    return $query->type == Enum::TYPE_DOCUMENT;
                }],
            ['file', 'file', 'skipOnEmpty' => true, 'extensions' => 'wav,mp3', 'on' => ['update'], 'when' => function($query) {
                    return $query->type == Enum::TYPE_AUDIO;
                }],
            ['file', 'file', 'skipOnEmpty' => true, 'extensions' => 'doc,docx,pdf', 'on' => ['update'], 'when' => function($query) {
                    return $query->type == Enum::TYPE_DOCUMENT;
                }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'class_id' => 'Class',
            'title' => 'Title',
            'type' => 'Type',
            'file' => 'File',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new TeacherUploadQuery(get_called_class());
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

class TeacherUploadQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => TeacherUpload::NOT_DELETED]);
    }

    public function weekly() {
        $dates = \backend\helpers\CustomHelper::getStartEndDates();
        return $this->andWhere(['and', ['df' => StudentUpload::NOT_DELETED], ['between', 'created_at', $dates['start_date'], $dates['end_date']]]);
    }

}
