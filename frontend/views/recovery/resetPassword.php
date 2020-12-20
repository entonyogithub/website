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
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(''); ?>
            <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => Yii::t('app', 'Confirm password')])->label(''); ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
