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
class CitiesAction extends \yii\base\Action {

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $governorate_id = $parents[0];
                $cities = \common\models\City::find()->where(['governorate_id' => $governorate_id])->notDeleted()->all();
                $out = $this->getChileds($cities);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function getChileds($model) {
        $arr = [];
        //$arr[] = ['id'=>'','name'=>Yii::t('app','Select city')];
        if ($model) {
            foreach ($model as $row) {
                $arr[] = ['id' => $row->id, 'name' => $row->name];
            }
        }
        return $arr;
    }

}
