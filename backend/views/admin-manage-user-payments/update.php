<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserPayment */

$this->title = 'Update User Payment: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Payments', 'url' => ['/admin-manage-users/view', "id" => $model->uid, '#' => 'w6-tab1']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-payment-update">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
