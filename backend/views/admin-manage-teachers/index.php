<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\editable\Editable;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Teachers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="panel mb25">
        <div class="panel-body">

            <p>
                <?= Html::a('Create Teacher', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::button('Search', ['data-target' => '#search-modal', 'data-toggle' => 'modal', 'class' => 'btn btn-primary']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Teachers </h3>',
                    'type' => 'primary'
                ],
                'pjaxSettings' => [
                    'options' => ['id' => 'grid'],
                    'neverTimeout' => true,
                ],
                'columns' => [
                    'id',
                    ['attribute' => 'First name',
                        'value' => 'teacherProfile.first_name',
                    ],
                    ['attribute' => 'Last name',
                        'value' => 'teacherProfile.last_name',
                    ],
                    'email:email',
                    [
                        'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'status',
                        'value' => 'statusval',
                        'editableOptions' => [
                            'header' => 'Status',
                            'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                            'data' => Yii::$app->params['userStatus'],
                            'options' => ['width' => '200px;'],
                            'editableValueOptions' => ['class' => 'text-success']
                        ],
                    ],
                    'created_at:datetime',
                    ['class' => 'common\components\RbacActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?= yii\web\View::render('_search', ['search' => $search]) ?>