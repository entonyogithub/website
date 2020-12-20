<?php
$title =  Yii::t('app', 'Reset Password');
$this->title = Yii::$app->name . '-' . $title
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
     <div class="login-header">
        <img src="<?= Url::to('@images') ?>/logo.png" alt="Home">
     </div> 
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset']); ?>
    <div class="container">
        <div class="col-sm-6">
            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'Email')])->label(''); ?>
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
