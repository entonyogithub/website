<?php
$this->title = Yii::$app->name . '-' .  Yii::t('app', 'Contact us');
?>
<?php

use \yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="container volunteer-form add-form form">
    <div class="col-lg-12">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="intro-text-wrap col-sm-7 text-center">
        <div class="intro-text big-text">
            بمعنى ان الغايه هش  الشكل  وليس المعنى , هنا نص شكلي
        </div>
    </div>
            <?php $form = ActiveForm::begin(['id' => 'form-add-volunteer']); ?>
    <div class="container">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => Yii::t('app', 'Full name')])->label(''); ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'Email')])->label(''); ?>
            <?= $form->field($model, 'subject')->textarea(['maxlength'=>true,'class'=>'form-control initiative-desc','placeholder' => Yii::t('app', 'Subject')])->label(''); ?>
          
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
