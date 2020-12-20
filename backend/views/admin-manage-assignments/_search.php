<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<?php $this->registerJs('     
    $("#search-form").submit(function(event){
         event.preventDefault();
        var form = $("#search-form");
         $.pjax.reload({
         url:form.attr("action"),
         data:form.serialize(),
         container:"#grid",
         });
         $("#search-modal").modal("hide");
        });
'); ?>
<div id="search-modal" class="modal modal-primary">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Assignment search</h4>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'search-form', 'action' => \yii\helpers\Url::to(['/admin-manage-assignments/index']), 'method' => 'get']); ?>
            <div class="modal-body">
                <?= $form->field($search, 'class')->dropDownList($classes, ['prompt' => Yii::t('app', 'Select')]); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('Search', ['class' => 'btn btn-outline']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->