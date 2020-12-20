<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use \yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "contact_request".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property integer $read
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $df
 */
class ContactRequest extends ActiveRecord {

    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;
    //Read request flag
    const NOT_READ_FLAG = 0;
    const READ_FLAG = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'contact_request';
    }

    /**
     * @inheritdoc
     */
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
            [['subject', 'name', 'email'], 'required'],
            [['read', 'created_at', 'updated_at', 'df'], 'integer'],
            ['email', 'email'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['subject'], 'string', 'max' => 500]
        ];
    }

    public static function find() {

        return new ContactRequestQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Full name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'read' => Yii::t('app', 'Read'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'df' => Yii::t('app', 'Df'),
        ];
    }

}

class ContactRequestQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => ContactRequest::NOT_DELETED]);
    }

}
