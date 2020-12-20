<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StudentClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-class-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'total_number_of_lectures')->textInput() ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'taken_lectures')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'minimum_uploads')->textInput() ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'minimum_listening')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'total_number_of_recording')->textInput() ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'total_number_of_listening')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'iam_in_uploads')->textInput() ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'iam_in_listenings')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'listening_duration')->textInput() ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'recording_duration')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?= $form->field($model, 'rating')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <?=
            $form->field($model, 'show_payment')->widget(kartik\switchinput\SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'YES',
                    'offText' => 'NO'
                ]
            ]);
            ?>
        </div>
        <div class="col-xs-12 col-md-6">
            <?=
            $form->field($model, 'enable_iam_in')->widget(kartik\switchinput\SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'YES',
                    'offText' => 'NO'
                ]
            ]);
            ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
