<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?=

GridView::widget([
    'dataProvider' => $logs,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'pjaxSettings' => [
        'neverTimeout' => true,
    ],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> Logs</h3>',
        'type' => 'primary'
    ],
    'toolbar' => false,
    'columns' => [
        "uid" => ["label" => "UserName", "format" => "raw", "value" => function($model) {
                return Html::a(Html::encode($model->user->username), ["/admin-manage-users/view", "id" => $model->user->id]);
            }],
        'start_titme',
        'end_time',
        'duration',
        'date',
    ],
]);
?>