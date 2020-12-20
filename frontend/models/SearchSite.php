<?php

namespace frontend\models;

use yii;
use common\models\Complaint;
use common\models\Initiative;
use common\models\Event;
use common\models\Project;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SearchSite extends yii\base\Model {

    // add the public attributes that will be used to store the data to be search
    public $keyword;
    public $type;

    // now set the rules to make those attributes safe

    public function rules() {
        return [
            // ... more stuff here
            [['keyword', 'type'], 'safe'],
                // ... more stuff here
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return yii\base\Model::scenarios();
    }

    public function search($params) {
        $arr = [];
        $this->load($params);
        switch ($this->type) {
            case 1:
                $arr = $this->getDataArr(Complaint::className(), $this->keyword, 'Complaint');
                break;
            case 2:
                $arr = $this->getDataArr(Event::className(), $this->keyword, 'Event');
                break;
            case 3:
                $arr = $this->getDataArr(Initiative::className(), $this->keyword, 'Initiative');
                break;
            case 4:
                $arr = $this->getDataArr(Project::className(), $this->keyword, 'Project');
                break;
            default:
                $arr1 = $this->getDataArr(Complaint::className(), $this->keyword, 'Complaint');
                $arr2 = $this->getDataArr(Event::className(), $this->keyword, 'Event');
                $arr3 = $this->getDataArr(Initiative::className(), $this->keyword, 'Initiative');
                $arr4 = $this->getDataArr(Project::className(), $this->keyword, 'Project');
                $arr = array_merge($arr1, $arr2, $arr3, $arr4);
                break;
        }

        $dataProvider = new yii\data\ArrayDataProvider(['allModels' => $arr,
            'sort' => [
                'attributes' => ['created'],
                'defaultOrder' => ['created' => SORT_DESC],
            ],
            'pagination' => ['pageSize' => 6]]);

        return $dataProvider;
    }

    private function getDataArr($model, $keyword = '', $type = '') {
        $arr = [];
        $test = \common\models\User::find()->one();
        $result = $model::find()->andFilterWhere(['or', ['like', 'title', $keyword], ['like', 'description', $keyword]])->active()->all();
        if ($model) {
            foreach ($result as $row) {
                $url = '';
                switch ($type) {
                    case 'Complaint':
                        $url = \frontend\helpers\CustomUrl::ViewComplaint($row);
                        break;
                    case 'Event':
                        $url = \frontend\helpers\CustomUrl::ViewEvent($row);
                        break;
                    case 'Initiative':
                        $url = \frontend\helpers\CustomUrl::ViewInitiative($row);
                        break;
                    case 'Project':
                        $url = \frontend\helpers\CustomUrl::ViewProject($row);
                        break;
                }
                $arr[] = [
                    'title' => $row->title,
                    'type' => Yii::t('app', $type),
                    'description' => $row->description,
                    'url' => $url,
                    'created' => Yii::$app->formatter->asDate($row->created_at, Yii::$app->params['dateFormat']['long']),
                    'image' => Url::to(Yii::$app->params['image']['w279x144']['url']) . '/' . $row->image,
                ];
            }
        }
        return $arr;
    }

}
