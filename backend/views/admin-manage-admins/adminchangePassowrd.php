<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Change passwrod';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel mb25">

    <div class="panel-heading"><h3><?= $this->title ?></h3></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <fieldset>
            <legend>Password information</legend>
            <?= $form->field($model, 'new_password')->passwordInput(); ?>
            <?= $form->field($model, 'confirm_password')->passwordInput(); ?>
        </fieldset>
        <div class="form-group">
            <?= Html::submitButton('Change passwrod', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>