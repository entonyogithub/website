<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\editable\Editable;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="panel mb25">
        <div class="panel-body">

            <p>
                <?= Html::a('Create admin', ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::button('Search', ['data-target' => '#search-modal', 'data-toggle' => 'modal', 'class' => 'btn btn-primary']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Admins </h3>',
                    'type' => 'primary'
                ],
                'pjaxSettings' => [
                    'options' => ['id' => 'grid'],
                    'neverTimeout' => true,
                ],
                'columns' => [
                    'id',
                    ['attribute' => 'name',
                        'value' => 'profile.name',
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
                    'updated_at:datetime',
                    ['class' => 'common\components\RbacActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?= yii\web\View::render('_search', ['search' => $search]) ?>