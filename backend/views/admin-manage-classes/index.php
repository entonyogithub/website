<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Classes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-class-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create Student Class', ['create'], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                ],
                'responsive'=>true,
                'responsiveWrap'=>true,
                'striped'=>false,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> student-class </h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    'title',
                    [
                        'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'taken_lectures',
                        'value' => 'LecturesVal',
                        'editableOptions' => function($model, $key, $index, $widget) {
                            return [
                                'header' => 'Taken lectures',
                                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                'data' => range(0, $model->total_number_of_lectures),
                                'options' => ['width' => '200px;'],
                                'editableValueOptions' => ['class' => 'text-success']
                            ];
                        }
                    ],
                    'total_number_of_recording',
                    'total_number_of_listening',
                    'listening_duration',
                    'recording_duration',
                    'rating',
                    'created_at:datetime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => Helper::filterActionColumn('{view} {update} {delete} '),
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
