<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface, \OAuth2\Storage\UserCredentialsInterface {

    const STATUS_BAN = -1;
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //Login types 
    const TYPE_NORMAL_USER = 1;
    const TYPE_FB_USER = 2;
    const TYPE_TWITTER_USER = 3;
    //Login types 
    const SOCIAL_REGISTERED_NO = 0;
    const SOCIAL_REGISTERED_YES = 1;
    //deleted or not flags
    const NOT_DELETED = 0;
    const DELETED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            [
                'class' => 'mdm\behaviors\ar\RelationBehavior',
            ],
        ];
    }

//    public function fields() {
//        $fields = parent::fields();
//
//        // remove fields that contain sensitive information
//        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token'], $fields['created_at']
//                , $fields['updated_at'], $fields['status'], $fields['role']);
//
//        $fields['created'] = function ($model) {
//            return Yii::$app->formatter->asDate($model->created_at);
//        };
//        $fields['updated'] = function ($model) {
//            return Yii::$app->formatter->asDate($model->updated_at);
//        };
//
//        return $fields;
//    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['last_visit', 'default', 'value' => 0],
            [['last_visit'], 'integer'],
            ['username', 'filter', 'filter' => 'trim'],
            [['username'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['password_hash', 'required'],
            ['password_hash', 'string', 'min' => 6],
            [['status'], 'in', 'range' => array_keys(\yii::$app->params['userStatus'])],
            [['status'], 'required'],
            [['role'], 'in', 'range' => User::getRoles(), 'on' => ['insert']],
            [['role'], 'required', 'on' => ['insert']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function checkUserCredentials($email, $password) {
        $user = self::findByUsername($email);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($email) {
        $user = self::findByUsername($email);
        return ['user_id' => $user->getId()];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $user_by_access_token = \springdev\yii2\oauth2mysqlserver\models\OauthAccessTokens::findOne(['access_token' => $token]);
        if ($user_by_access_token)
            return static::findOne(['id' => $user_by_access_token->user_id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Finds out if Activation token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isActivationKeyValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.ActivationExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    public static function find() {

        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates Activiation code key
     */
    public function generateActiveKey() {
        $this->activation_code = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * 
     * @param int $user_id
     * @return user roles
     */
    public static function getUserRole($user_id, $allRoles = 0) {
        $arr = array_keys(\Yii::$app->authManager->getRolesByUser($user_id));
        if (!empty($arr)) {
            if ($allRoles == 1)
                return $arr;
            else
                return $arr[0];
        }
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile() {
        return $this->hasOne(Profile::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile() {
        return $this->hasOne(UserProfile::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherProfile() {
        return $this->hasOne(TeacherProfile::className(), ['uid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUploads() {
        return $this->hasOne(StudentUpload::className(), ['uid' => 'id'])->weekly()->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListenings() {
        return $this->hasOne(StudentListening::className(), ['uid' => 'id'])->weekly()->count();
    }

    /**
     * Add role to user on registration
     * @param String $role
     * @param Object $user
     */
    public function addRole($role, $user) {
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $this->role = $authorRole->name;
        if ($auth->assign($authorRole, $user->id)) {
            $this->save();
        }
    }

    public function removeRole($role, $user) {
        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $this->role = NULL;
        if ($auth->revoke($authorRole, $user->id)) {
            $this->save();
        }
    }

    public static function getUsersByRole($role_name) {
        $query = User::find()
                ->select('user.*')
                ->innerJoin('auth_assignment', '`auth_assignment`.`user_id` = `user`.`id`')
                ->where(['auth_assignment.item_name' => $role_name]);
        return $query;
    }

    /**
     * Get users by role_name
     * @param type $role_name
     * @return type
     */
    public static function getRoleUsers2($role_name) {
        $query = User::find()
                ->select('user.*')
                ->innerJoin('auth_assignment', '`auth_assignment`.`user_id` = `user`.`id`')
                ->where(['auth_assignment.item_name' => $role_name])
                ->notDeleted();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
//        $dataProvider->setSort([
//            'attributes' => [
//                'id',
//                'fullName' => [
//                    'asc' => ['profile.name' => SORT_ASC],
//                    'desc' => ['profile.name' => SORT_DESC],
//                    'label' => 'Full Name',
//                    'default' => SORT_ASC
//                ],
//                'status',
//            ]
//        ]);
        return $dataProvider;
    }

    /**
     * Get all Roles in app
     * @param int $all
     * @return array of all types 
     */
    public static function getRoles($all = 0) {
        $roles = Yii::$app->authManager->getRoles();
        if ($all == 0) {
            unset($roles['Guests']);
        }
        $arr = array();
        foreach (array_keys($roles) as $role)
            $arr[$role] = $role;
        return $arr;
    }

    /* Getter for person full name */

    public function getFullName() {
        return $this->profile->name;
    }

    public function getStatusVal() {
        return Yii::$app->params['userStatus'][$this->status];
    }

    public static function itemAlias($type = '', $index = null) {
        $arr = [
            'gender' => [
                1 => Yii::t('app', 'Male'),
                2 => Yii::t('app', 'Female'),
            ],
        ];
        if (isset($index))
            return isset($arr[$type][$index]) ? $arr[$type][$index] : false;
        else
            return isset($arr[$type]) ? $arr[$type] : false;
    }

}

class UserQuery extends ActiveQuery {

    public function notDeleted() {

        return $this->andWhere(['df' => User::NOT_DELETED]);
    }

    public function active() {

        return $this->andWhere(['df' => User::NOT_DELETED, 'status' => User::STATUS_ACTIVE]);
    }

}
