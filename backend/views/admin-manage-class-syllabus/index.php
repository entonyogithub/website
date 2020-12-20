<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Class Syllabi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-syllabus-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create Class Syllabus', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> class-syllabus </h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    ['label' => 'Class', 'value' => 'class.title'],
                    ['label' => 'Title', 'value' => 'record.title'],
                    ['label' => 'Date', 'value' => function($model) {
                            $timestamp = strtotime($model->date);
                            $day = date('l', $timestamp);
                            return $day . " ( $model->date ) ";
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