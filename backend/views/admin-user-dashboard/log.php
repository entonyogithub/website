<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attendance Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attendance-log-index">

    <div class="panel mb25">
        <div class="panel-body">
            <?=
            GridView::widget([
                'dataProvider' => $records,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'options'=>['id'=>'imported-logs']
                ],
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> attendance-log </h3>',
                    'type' => 'primary'
                ],
                  'toolbar'=>false,
                'columns' => [
                    'id',
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
        </div>
    </div>
</div>
