<?php

use kartik\grid\GridView;

?>
<div class="assignment-index">
<?=

GridView::widget([
    'dataProvider' => $assignments,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-tasks"></i> Assignments </h3>',
        'type' => 'primary'
    ],
    'pjaxSettings' => [
        'options' => ['id' => 'grid'],
        'neverTimeout' => true,
    ],
    'toolbar' => false,
    'columns' => [
        'title',
        'created_at:datetime',
    ],
]);
?>
</div>