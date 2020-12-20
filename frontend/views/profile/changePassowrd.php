<?php $this->title = Yii::$app->name.'-'.Yii::t('app','Change password'); ?>
<?php 
use \yii\helpers\Html; 
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="container user-profile-page user-section">

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'form-changepass', 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
         <div class="col-sm-12 pull-right grey-bg form ">
            <div class="page-header">
                <div class="page-title">
                    <?= Yii::t('app','Change password'); ?>
                </div>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
            </div>
            <div class="form-wrap pull-right col-sm-5">
                <?= $form->field($model, 'old_password')->passwordInput(); ?>
                <?= $form->field($model, 'new_password')->passwordInput(); ?>
                <?= $form->field($model, 'confirm_password')->passwordInput(); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
       
    </div>

</div>