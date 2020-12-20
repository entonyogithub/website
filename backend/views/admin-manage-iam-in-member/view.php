<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $model common\models\IamInMember */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Iam In Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iam-in-member-view">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('update')): ?>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>
                <?php  if (Helper::checkRoute('delete')): ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
                ],
                ]) ?>
                <?php endif; ?>
            </p>
            <?= DetailView::widget([
		'model'=>$model,
                'bordered' => true,
    		'panel' => [
     		'heading' => $model->id,
      	        'type' => DetailView::TYPE_PRIMARY,
//              'headingOptions' => ['template' => '{title}']
    ],
    'hAlign' => DetailView::ALIGN_LEFT,
            'attributes' => [
                        'id',
            'uid',
            'listening_count',
            'recording_count',
            'created_at',
            'updated_at',
            ],
            ]) ?>
        </div>
    </div>
</div>
