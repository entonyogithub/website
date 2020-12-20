<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?=

yii\web\View::render('_addUser', [
    'id' => "add-user-form",
    'model' => $model,
    'addForm' => $addForm,
    'users' => $addForm->users,
    'link' => \yii\helpers\Url::to(['/admin-manage-classes/add-student'])])
?>

<?=

GridView::widget([
    'dataProvider' => $students,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => "student-grid"],
        'neverTimeout' => true,
    ],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i>Students</h3>',
        'type' => 'primary'
    ],
    'columns' => [
        'id',
        ['label' => "Username", 'format' => 'raw', 'value' => function($model) {
                return yii\bootstrap\Html::a(yii\bootstrap\Html::encode($model->user->username), ['/admin-manage-users/view', 'id' => $model->uid], ['pjax-data' => "0"]);
            }],
        ['label' => "Total uploads", 'value' => function($model) {
                return $model->user->uploads;
            }],
        ['label' => "Total Listings", 'value' => function($model) {
                return $model->user->listenings;
            }],
        ['label' => 'Messages', 'format' => 'raw', 'value' => function($model) {
                $span = '';
                if ($count = common\models\Message::find()->where(['uid' => $model->user->id, 'read' => \common\models\Enum::ANSWER_NO, 'type' => \common\models\Message::MESSAGE_USER])->count())
                    $span = "<span class='red-circle'>$count</span>";
                return \yii\bootstrap\Html::a("Messages$span", ['/admin-manage-users/messages', 'id' => $model->user->id], ['class' => 'btn btn-success', 'pjax-data' => "0"]);
            }],
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'delete') {
                    $url = 'delete-student?id=' . $model->id;
                    return $url;
                }
            }
        ],
    ],
]);
?>