<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\actions;

use Yii;
use yii\helpers\Json;
use yii\web\ServerErrorHttpException;

/**
 * CreateAction implements the API endpoint for creating a new model from the given data.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DistrictAction extends \yii\base\Action {

    
    public function run() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $city_id = $parents[0];
                $districts = \common\models\District::find()->where(['city_id' => $city_id])->notDeleted()->all();
                $out = $this->getChileds($districts);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function getChileds($model) {
        $arr =[];
        if ($model) {
            foreach ($model as $row) {
                $arr[] = ['id' => $row->id, 'name' => $row->name];
            }
        }
        return $arr;
    }

}
