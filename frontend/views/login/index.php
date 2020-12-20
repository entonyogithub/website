<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::$app->name . '-' . Yii::t('app','Login'); 
$this->params['breadcrumbs'][] = $this->title;
?>

<div  class="login-form form add-form ">
    <div class="container">
        <div class="col-sm-6">
            <div class="login-header">
                <img src="<?= \yii\helpers\Url::to('@images') ?>/logo.png" alt="Home">
            </div>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <!--                <div class="form-group">
                                <input type="email" class="form-control" id="inputmail" placeholder="البريد الالكتروني">
                            </div>-->
            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'Email')])->label('') ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label('') ?>
            <div class="form-group remember-info pull-right">
<?= Html::activeCheckbox($model, 'rememberMe', ['class' => 'pull-right', 'label' => Yii::t('app', 'Remember me')]); ?>
            </div>
            <div class="forgot-pwd pull-left">
                <a href="<?= \yii\helpers\Url::to('recovery') ?>"><?= Yii::t('app', 'Forget password'); ?></a>
            </div>
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn  btn-colored', 'name' => 'login-button']) ?>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

