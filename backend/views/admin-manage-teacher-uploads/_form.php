<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherUpload */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-upload-form">
    <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?=
    $form->field($model, 'class_id')->widget(kartik\select2\Select2::classname(), [
        'data' => $classes,
        'language' => 'en',
        'options' => ['placeholder' => 'Select'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'type')->widget(kartik\select2\Select2::classname(), [
        'data' => \common\models\Enum::itemAlias('types'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
    <?=
    $form->field($model, "file")->widget(\kartik\file\FileInput::classname(), [
        "options" => ["multiple" => false],
        "pluginOptions" => $file_options
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
