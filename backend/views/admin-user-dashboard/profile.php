<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
?>
<?=

DetailView::widget([
    'model' => $model,
    'hover' => true,
    'bordered' => true,
    'panel' => [
        'heading' => $model->userProfile->first_name . ' ' . $model->userProfile->last_name . ' ( ' . $model->username . ' )',
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
        ['label' => "First name", 'value' => $model->userProfile->first_name],
        ['label' => "Last name", 'value' => $model->userProfile->last_name],
        ['label' => "Phone", 'value' => $model->userProfile->mobile],
        ['label' => "Age", 'value' => $model->userProfile->age],
        ['label' => "Address", 'value' => $model->userProfile->address],
        'email:email',
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
    ],
])
?>

