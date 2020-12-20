<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\editable\Editable;
use kartik\export\ExportMenu;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="panel mb25">
        <div class="panel-body">

            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create user', ['create'], ['class' => 'btn btn-success']) ?>
                <?php endif; ?>

                <?= Html::button('Search', ['data-target' => '#search-modal', 'data-toggle' => 'modal', 'class' => 'btn btn-primary']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Users </h3>',
                    'type' => 'primary'
                ],
                'pjaxSettings' => [
                    'options' => ['id' => 'grid'],
                    'neverTimeout' => true,
                ],
                'columns' => [
                    'id',
                    'username',
                    ['attribute' => 'First name',
                        'value' => 'userProfile.first_name',
                    ],
                    ['attribute' => 'Last name',
                        'value' => 'userProfile.last_name',
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
                    ['label' => 'Messages', 'format' => 'raw', 'value' => function($model) {
                            $span = '';
                            if ($count = common\models\Message::find()->where(['uid' => $model->id, 'read' => \common\models\Enum::ANSWER_NO, 'type' => \common\models\Message::MESSAGE_USER])->count())
                                $span = "<span class='red-circle'>$count</span>";
                            return \yii\bootstrap\Html::a("Messages$span", ['messages', 'id' => $model->id], ['class' => 'btn btn-success', 'pjax-data' => "0"]);
                        }],
                    ['class' => 'common\components\RbacActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<?= yii\web\View::render('_search', ['search' => $search]) ?>