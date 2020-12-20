<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
?>

<div class="row no-margin loginform">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4"> 

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false, 'options' => ['class' => 'form-layout']]); ?>
        <div class="text-center login-logo">
            <image src="<?= Url::to('/admin/images/logo.jpeg') ?>" alt="Jarra logo"/>
        </div> <p class="text-center mb30">Entoneyo's students dashboard. Please sign in to your account</p>
        <div class="form-inputs">
            <?=
                    $form
                    ->field($model, 'username')
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('username'), 'class' => 'form-control input-lg'])
            ?>

            <?=
                    $form
                    ->field($model, 'password')
                    ->label(false)
                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'class' => 'form-control input-lg'])
            ?>
        </div>
        <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-lg mb15', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->