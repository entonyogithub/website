<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-payment-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create User Payment', ['create'], ['class' => 'btn btn-success']) ?>
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
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> user-payment </h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    "uid" => ["label" => "Created by", "format" => "raw", "value" => function($model) {
                            return Html::a(Html::encode($model->user->username), ["/admin-user/view", "id" => $model->user->id]);
                        }],
                    'amount',
                    'created_at:datetime',
                    'updated_at:datetime',
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
