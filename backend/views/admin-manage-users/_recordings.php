<?php
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
?>
<?=
GridView::widget([
    'dataProvider' => $uploads,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Recordings </h3>',
        'type' => 'primary'
    ],
    'pjaxSettings' => [
        'options' => ['id' => 'recordings-grid'],
        'neverTimeout' => true,
    ],
    'columns' => [
        'id',
        'user.username',
        'file' => ["format" => "raw", "label" => "File", "format" => "raw", "value" => function($model) {
                return "<audio controls controlsList='nodownload'><source type='audio/mpeg' src='" . $model->getUploadUrl("file") . "'><source type='audio/ogg' src='" . $model->getUploadUrl("file") . "'></audio>";
            }],
        'created_at:datetime',
    ],
]);
?>
