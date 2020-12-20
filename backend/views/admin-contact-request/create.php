<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContactRequest */

$this->title = 'Create Contact Request';
$this->params['breadcrumbs'][] = ['label' => 'Contact Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-request-create">

    <div class="box">
        <div class="box-body">

            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
