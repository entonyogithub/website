<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
/* @var $form yii\widgets\ActiveForm */
if ($model->type == \common\models\Setting::TYPE_IMAGE) {
    $options = [
        'initialPreview' => [
            Html::img($model->getUploadUrl('value'), ['class' => 'file-preview-image', 'alt' => $model->value, 'title' => $model->value]),
        ],
        'showUpload' => false,
        'showRemove' => false,
        'initialCaption' => $model->value,
        'overwriteInitial' => false
    ];
}
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(common\models\Setting::itemAlias('type')) ?>
    <?php if ($model->type == \common\models\Setting::TYPE_IMAGE): ?>
        <?=
        $form->field($model, 'value')->widget(\kartik\file\FileInput::classname(), [
            'options' => ['multiple' => false, 'accept' => 'image/*'],
            'pluginOptions' => $options,
        ])->label('Image');
        ?>
    <?php else: ?>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
