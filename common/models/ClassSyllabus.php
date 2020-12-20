<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "class_syllabus".
 *
 * @property integer $id
 * @property integer $class_id
 * @property integer $record_id
 * @property string $date
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class ClassSyllabus extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'class_syllabus';
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
            [['class_id', 'record_id',], 'required'],
            [['class_id', 'record_id', 'created_at', 'updated_at', 'df'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'class_id' => 'Class',
            'record_id' => 'Syllabus Record',
            'date' => 'Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new ClassSyllabusQuery(get_called_class());
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
    public function getRecord() {
        return $this->hasOne(Syllabus::className(), ['id' => 'record_id']);
    }

}

class ClassSyllabusQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => ClassSyllabus::NOT_DELETED]);
    }

}
