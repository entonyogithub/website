<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "assignment".
 *
 * @property integer $id
 * @property integer $class_id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class Assignment extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'assignment';
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
            [['class_id', 'title'], 'required'],
            [['class_id', 'created_at', 'updated_at', 'df'], 'integer'],
            [['title'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'class_id' => 'Class',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new AssignmentQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass() {
        return $this->hasOne(StudentClass::className(), ['id' => 'class_id']);
    }

}

class AssignmentQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => Assignment::NOT_DELETED]);
    }

    public function weekly() {
        $dates = \backend\helpers\CustomHelper::getStartEndDates();
        return $this->andWhere(['and', ['df' => StudentUpload::NOT_DELETED], ['between', 'created_at', $dates['start_date'], $dates['end_date']]]);
    }

}
