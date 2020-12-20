<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?>

<?=

yii\web\View::render('_addUser', [
    'id' => "add-teacher-form",
    'model' => $model,
    'addForm' => $addForm,
    'users' => $addForm->teachers,
    'link' => \yii\helpers\Url::to(['/admin-manage-classes/add-teacher'])])
?>
<?=

GridView::widget([
    'dataProvider' => $teachers,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => "teachers-grid"],
        'neverTimeout' => true,
    ],
    'columns' => [
        'id',
        ['label' => "Username", 'value' => "user.username"],
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'delete') {
                    $url = 'delete-teacher?id=' . $model->id;
                    return $url;
                }
            }
        ],
    ],
]);
?>