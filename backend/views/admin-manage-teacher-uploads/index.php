<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teacher Uploads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-upload-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create Teacher Upload', ['create'], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>
                <?= Html::button('Search', ['data-target' => '#search-modal', 'data-toggle' => 'modal', 'class' => 'btn btn-primary']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
               'pjaxSettings' => [
                    'options' => ['id' => 'grid'],
                    'neverTimeout' => true,
                ],
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> teacher-upload </h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    "class_id" => ["label" => "Class", "format" => "raw", "value" => 'class.title'],
//                    'class_id' => ["label" => "Class", "format" => "raw", "value" => function($model) {
//                            return $model->class->title;
//                        }],
                    'title',
                    'type' => ["label" => "Type", "format" => "raw", "value" => function($model) {
                            return \common\models\Enum::itemAlias('types', $model->type);
                        }],
                    'file' => ["format" => "raw", "label" => "File", "format" => "raw", "value" => function($model) {
                            if ($model->type == \common\models\Enum::TYPE_DOCUMENT) {
                                return yii\bootstrap\Html::a("Check file", $model->getUploadUrl("file"), ['data-pjax' => "0", "target" => "_BLANK"]);
                            }
                            return "<audio controls controlsList='nodownload'><source type='audio/mpeg' src='" . $model->getUploadUrl("file") . "'></audio>";
                        }],
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
<?= yii\web\View::render('_search', ['search' => $search, 'classes' => $classes]) ?>