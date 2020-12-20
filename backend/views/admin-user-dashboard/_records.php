<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?=

GridView::widget([
    'dataProvider' => $records,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'pjaxSettings' => [
        'neverTimeout' => true,
    ],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> Logs</h3>',
        'type' => 'primary'
    ],
    'toolbar'=>false,
    'columns' => [
        ['label' => 'Title', 'value' => 'record.title'],
        ['label' => 'Date', 'value' => function($model) {
                $timestamp = strtotime($model->date);
                $day = date('l', $timestamp);
                return $day . " ( $model->date ) ";
            }],
    ],
]);
?>