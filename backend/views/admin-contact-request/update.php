<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactRequest */

$this->title = 'Update Contact Request: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contact Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contact-request-update">

    <div class="box">
        <div class="box-body">

            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
