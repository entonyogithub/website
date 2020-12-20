<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ClassSyllabus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="class-syllabus-form">
    <?php $form = ActiveForm::begin(); ?>

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

    <?=
    $form->field($model, 'record_id')->widget(kartik\select2\Select2::classname(), [
        'data' => $records,
        'language' => 'en',
        'options' => ['placeholder' => 'Select'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'date')->widget(
            \dosamigos\datepicker\DatePicker::className(), [
        // inline too, not bad
        // modify template for custom rendering
        'template' => '{addon}{input}',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
