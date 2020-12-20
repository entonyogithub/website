<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="panel mb25">
        <div class="panel-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
//                    [
//                        'label' => 'Image',
//                        'format' => 'raw',
//                        'value' => Html::img(yii\helpers\Url::to(Yii::$app->params['image']['w160x160']['url']) . '/' . $model->profile->photo, ['class' => 'img-responsive']),
//                    ],
//                    'id',
//                    'fullname',
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
                    'updated_at:datetime',
                ],
            ])
            ?>
        </div>
    </div>
</div>