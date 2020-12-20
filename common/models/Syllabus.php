<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "syllabus".
 *
 * @property integer $id
 * @property integer $class_id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class Syllabus extends \yii\db\ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'syllabus';
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
            [['title'], 'required'],
            [[ 'created_at', 'updated_at', 'df'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'df' => 'Df',
        ];
    }

    public static function find() {

        return new SyllabusQuery(get_called_class());
    }

}

class SyllabusQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => Syllabus::NOT_DELETED]);
    }

}
