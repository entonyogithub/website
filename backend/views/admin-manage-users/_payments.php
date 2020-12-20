<?php
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use mdm\admin\components\Helper;
?>
<p>
      <?php if (Helper::checkRoute('create')): ?>
    <?= Html::a('Add Payment', ['/admin-manage-user-payments/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
</p>
<?=
GridView::widget([
    'dataProvider' => $payments,
    'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
    'pjax' => true,
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Payments </h3>',
        'type' => 'primary'
    ],
    'pjaxSettings' => [
        'options' => ['id' => 'grid'],
        'neverTimeout' => true,
    ],
    'columns' => [
        'id',
        'amount',
        'created_at:datetime',
        [
            'class' => 'common\components\RbacActionColumn',
            'template'=>'{view} {delete}',
            'controller' => 'admin-manage-user-payments'
        ],
    ],
]);
?>