<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher_profile".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 */
class TeacherProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_profile';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {       
        return [
            [['first_name','last_name','mobile'], 'required'],
            [['uid'], 'integer'],
            [['first_name', 'last_name', 'mobile'], 'string', 'max' => 255]
        ,
                ];
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile' => 'Mobile',
        ];
    }
    }
