<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Iam In Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iam-in-member-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create Iam In Member', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> I am In Members</h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    "class" => ["label" => "Class", "format" => "raw", "value" => 'class.title'],
                    "uid" => ["label" => "User", "format" => "raw", "value" => function($model) {
                            return Html::a(Html::encode($model->user->username), ["/admin-manage-users/view", "id" => $model->user->id]);
                        }],
                    'listening_count',
                    'recording_count',
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
