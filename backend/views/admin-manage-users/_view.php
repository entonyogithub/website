<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use \mdm\admin\components\Helper;
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
    'hover' => true,
    'bordered' => true,
    'panel' => [
        'heading' => $model->userProfile->first_name . ' ' . $model->userProfile->last_name . ' ( ' . $model->email . ' )',
        'type' => DetailView::TYPE_PRIMARY,
//        'headingOptions' => ['template' => '{title}']
    ],
    'enableEditMode' => false,
    'hAlign' => DetailView::ALIGN_LEFT,
    'attributes' => [
//                    [
//                        'label' => 'Image',
//                        'format' => 'raw',
//                        'value' => Html::img(yii\helpers\Url::to(Yii::$app->params['image']['w160x160']['url']) . '/' . $model->profile->photo, ['class' => 'img-responsive']),
//                    ],
//                    'id',
        'username',
        ['label' => "Full Name", 'value' =>  $model->userProfile->first_name." ".$model->userProfile->last_name],
        'email:email',
        ['label' => "Phone", 'value' => $model->userProfile->mobile],
        ['label' => "Age", 'value' => $model->userProfile->age],
        ['label' => "Address", 'value' => $model->userProfile->address],
        ['label' => "Balance", 'value' => $model->userProfile->balance],
        'status' => [
            'label' => 'Status',
            'value' => $model->statusval,
        ],
//                    [
//                        'label' => 'Mobile',
//                        'format' => 'raw',
//                        'value' => $model->profile->mobile,
//                    ],
//                    [
//                        'label' => 'Date of birth',
//                        'format' => 'raw',
//                        'value' => $model->profile->date_of_birth,
//                    ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
])
?>

