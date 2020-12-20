<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile
 * @property double $balance
 *
 * @property User $u
 */
class UserProfile extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['first_name', 'last_name', 'mobile', 'date_of_birth', 'address', 'balance','finger_print_id'], 'required'],
            [['uid','finger_print_id'], 'integer'],
            [['balance'], 'number'],
            [['first_name', 'last_name', 'mobile'], 'string', 'max' => 255],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
            ['date_of_birth', 'date', 'format' => 'yyyy-mm-dd'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile' => 'Mobile',
            'date_of_birth' => 'Date of birth',
            'address' => 'Address',
            'balance' => 'Balance',
            'finger_print_id'=>'Finger Print ID'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAge() {
        $dateOfBirth = $this->date_of_birth;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }

}
