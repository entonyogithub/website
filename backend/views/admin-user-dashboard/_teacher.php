<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?=

GridView::widget([
    'dataProvider' => $teacher_uploads,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'pjaxSettings' => [
        'neverTimeout' => true,
    ],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> Teacher Uploads </h3>',
        'type' => 'primary'
    ],
    'columns' => [
        'title',
        'type' => ["label" => "Type", "format" => "raw", "value" => function($model) {
                return \common\models\Enum::itemAlias('types', $model->type);
            }],
        'file' => ["format" => "raw", "label" => "File", "format" => "raw", "value" => function($model) {
                if ($model->type == \common\models\Enum::TYPE_DOCUMENT) {
                    return yii\bootstrap\Html::a("Check file", $model->getUploadUrl("file"), ['data-pjax' => "0", "target" => "_BLANK"]);
                }
                $exist_record = \common\models\StudentListening::find()->where(['uid' => Yii::$app->user->id, 'class_id' => $model->class_id])->andWhere("FROM_UNIXTIME(created_at,'%Y-%m-%d') = CURDATE()")->count();
                if ($exist_record == 0)
                    return "<div><audio  ontimeupdate='js:updateListen(this," . $model->id . "," . $model->class_id . "," . ($model->class->listening_duration * 60) . ")' controls='' controlsList='nodownload'><source type='audio/mpeg' src='" . $model->getUploadUrl("file") . "'></audio></div>";
                else
                    return "<div><audio  controls='' controlsList='nodownload'><source type='audio/mpeg' src='" . $model->getUploadUrl("file") . "'></audio></div>";
            }],
        'created_at:datetime',
    ],
]);
?>