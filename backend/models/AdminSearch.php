<?php

namespace backend\models;

use yii;
use \common\models\User;
use yii\data\ActiveDataProvider;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminSearch extends User {

    // add the public attributes that will be used to store the data to be search
    public $email;
    public $name;
    public $status;
    public $role;

    // now set the rules to make those attributes safe
    public function rules() {
        return [
            // ... more stuff here
            [['email', 'name', 'status', 'role'], 'safe'],
                // ... more stuff here
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return yii\base\Model::scenarios();
    }

    public function search($params) {
        $query = User::find()->joinWith(['profile'])
                ->where(['role' => 'Admins'])
                ->notDeleted();

        $dataProvider = new ActiveDataProvider(['query' => $query->orderBy('created_at DESC')]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user.email', $this->email]);
        $query->andFilterWhere(['like', 'profile.name', $this->name]);
        $query->andFilterWhere(['user.status' => $this->status]);


        return $dataProvider;
    }

}
