<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <fieldset>
        <legend>Login Information</legend>
         <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?php if ($model->isNewRecord): ?>
            <?= $form->field($model, 'password_hash')->passwordInput() ?>
        <?php else: ?>
            <?= Html::a('Change passwrod', ['admin-manage-administrators/admin-change-password', 'id' => $model->id],['class'=>'btn btn-success']) ?>
        <?php endif; ?>

        <?= $form->field($model, 'status')->dropDownList(yii::$app->params['userStatus'], ['prompt' => 'Select']); ?>
        <?= $form->field($model, 'role')->textInput(['disabled' => true]); ?>
    </fieldset>
    <div id="profiles">
        <?= $this->render('_profile', ['form' => $form, 'profile' => $profile]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
