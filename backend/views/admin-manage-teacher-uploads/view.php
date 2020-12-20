<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherUpload */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Teacher Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-upload-view">
    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('update')): ?>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>
                <?php if (Helper::checkRoute('delete')): ?>
                    <?=
                    Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
            <?php endif; ?>
            </p>
            <?=
            DetailView::widget([
                'model' => $model,
                'bordered' => true,
                'panel' => [
                    'heading' => $model->title,
                    'type' => DetailView::TYPE_PRIMARY,
//              'headingOptions' => ['template' => '{title}']
                ],
                'hAlign' => DetailView::ALIGN_LEFT,
                'attributes' => [
                    'id',
                    'uid'=>['label'=>"Created by ","value"=>$model->user->email],
                    'class_id'=> ['label'=>"Class","value"=>$model->class->title],
                    'title',
                    'type'=> ['label'=>"Type","value"=>\common\models\Enum::itemAlias('types',$model->type)],
                    'type'=> ["format"=>"raw",'label'=>"Type","value"=>$model->type == \common\models\Enum::TYPE_DOCUMENT ?  : "<audio controls><source type='audio/mpeg' src='".yii\helpers\Url::to($model->getUploadUrl("file"),true)."'></audio>"],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ])
            ?>
        </div>
    </div>
</div>
