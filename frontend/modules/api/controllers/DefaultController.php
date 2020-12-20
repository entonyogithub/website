<?php

namespace app\modules\api\controllers;

use yii\helpers\Html;

use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use springdev\yii2\oauth2mysqlserver\filters\ErrorToExceptionFilter;
use springdev\yii2\oauth2mysqlserver\filters\auth\CompositeAuth;

class DefaultController extends \yii\rest\Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'exceptionFilter' => [
                        'class' => ErrorToExceptionFilter::className()
                    ],
        ]);
    }

    public function actionIndex() {
        echo 1 ;
    }

}
