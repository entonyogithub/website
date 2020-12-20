<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="heat-map-search">
    <?php
    $form = ActiveForm::begin([
                'id' => $id,
                'action' => $link,
                'method' => 'post',
                    ]
    );
    ?>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <?= $form->field($addForm, 'uid')->dropDownList($users, ['prompt' => 'Select User'])->label(false); ?>
            <?= $form->field($addForm, 'class_id')->hiddenInput(['value'=>$model->id])->label(false) ?>
        </div>
        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <div id="generl-error" class="has-error hide">
        <p class="help-block help-block-error">asdasdasd</p>
    </div>
    <?php ActiveForm::end(); ?>
</div><!-- /.modal-content -->