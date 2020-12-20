<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use mdm\admin\components\Helper;
?>           
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
    'enableEditMode' => false,
    'hAlign' => DetailView::ALIGN_LEFT,
    'attributes' => [
        'id',
        'uid',
        'title',
        'total_number_of_lectures',
        'taken_lectures',
        'minimum_uploads',
        'minimum_listening',
        'total_number_of_recording',
        'total_number_of_listening',
        'listening_duration',
        'recording_duration',
        'rating',
        'show_payment',
        'enable_iam_in',
        'created_at:datetime',
        'updated_at:datetime',
    ],
])
?>