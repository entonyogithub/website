<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assignment-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create Assignment', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> Assignment </h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    ['label' => 'Class', 'value' => 'class.title'],
                    'title',
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