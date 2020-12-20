<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserPayment */

$this->title = 'Create User Payment';
$this->params['breadcrumbs'][] = ['label' => 'User Payments', 'url' => ['/admin-manage-users/view', "id" => Yii::$app->request->get('id'), '#' => 'w6-tab1']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-payment-create">

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
