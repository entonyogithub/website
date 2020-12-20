<?php
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
?>
<?=
GridView::widget([
    'dataProvider' => $listenings,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Recordings </h3>',
        'type' => 'primary'
    ],
    'pjaxSettings' => [
        'options' => ['id' => 'lisenting-grid'],
        'neverTimeout' => true,
    ],
    'columns' => [
        'id',
        'user.username',
        'upload_id',
        'created_at:datetime',
    ],
]);
?>