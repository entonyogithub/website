<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\IamInMember */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="iam-in-member-form">
            <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'listening_count')->textInput() ?>

    <?= $form->field($model, 'recording_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
