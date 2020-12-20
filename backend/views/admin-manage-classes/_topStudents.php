<?php

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

?>
<?=

GridView::widget([
    'dataProvider' => $topStudents,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Top Students </h3>',
        'type' => 'primary'
    ],
    'pjaxSettings' => [
        'options' => ['id' => 'grid'],
        'neverTimeout' => true,
    ],
    'toolbar'=>false,
    'columns' => [
        'name',
        'age'
    ],
]);
?>