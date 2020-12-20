<?php

namespace frontend\controllers;

use Yii;

class SearchController extends \yii\web\Controller
{
    public function actionIndex()
    {   $search = new \frontend\models\SearchSite;
        $results = $search->search(Yii::$app->request->queryParams);
        return $this->render('index',['results'=>$results,'search'=>$search]);
    }

}
