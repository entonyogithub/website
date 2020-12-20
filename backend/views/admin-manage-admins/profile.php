<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::$app->user->identity->fullname . ' Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel mb25">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary([$model, $profile]); ?>
        <fieldset>
            <legend>Login Information</legend>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= Html::a('Change passwrod', ['admin-user/change-password']) ?>
        </fieldset>
        <?= $this->render('_profile', ['form' => $form, 'profile' => $profile, 'photo_options' => $photo_options]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>