<?php

namespace backend\models;

use yii;
use common\models\IamInMember;
use yii\data\ActiveDataProvider;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class IamInMemmbersSearch extends IamInMember {

    // add the public attributes that will be used to store the data to be search
    public $class;

    // now set the rules to make those attributes safe
    public function rules() {
        return [
            // ... more stuff here
            [['class'], 'safe'],
                // ... more stuff here
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return yii\base\Model::scenarios();
    }

    public function search($params) {
        if (Yii::$app->user->identity->role == "Teachers") {
            $teacher_classes = \yii\helpers\ArrayHelper::map(\common\models\TeacherClass::find()->where(['uid' => Yii::$app->user->id])->all(), 'class_id', 'class_id');
            $query = IamInMember::find()->where(['in', 'class_id', $teacher_classes])->weekly();
        } else {
            $query = IamInMember::find()->weekly();
        }

        $dataProvider = new ActiveDataProvider(['query' => $query->orderBy('created_at DESC')]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['class_id' => $this->class]);


        return $dataProvider;
    }

}
