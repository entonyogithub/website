<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attendance Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerJs('
    $("#upload-members").on("beforeSubmit", function (event) {
    $("#member-import-submit").button("loading");
    var formData = new FormData($("#upload-members")[0]);
    $.ajax({
            method:"post",
            dataType:"json",
            url: "/admin/admin-manage-attendance-logs/import",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
            $("#import-errors").removeClass("alert alert-error")
            $("#import-errors").empty()
            $("#member-import-submit").button("reset");
            if(response.success == 1){
            $.pjax.reload({container:"#imported-logs"});
            if(response.error.length == 0){
            $("#import-modal").modal("hide");}
            else{
            $("#import-errors").addClass("alert alert-error")
            $("#import-errors").append(response.error)
            }
            }else{
             alert(response.error)
             }
            }
       });
     return false;
    });  
        ', yii\web\View::POS_READY) ?>
<div class="attendance-log-index">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?php if (Helper::checkRoute('create')): ?>
                    <?= Html::a('Create Attendance Log', ['create'], ['class' => 'btn btn-success']) ?>
                    <?php
                    Modal::begin([
                        'id' => 'import-modal',
                        'header' => Yii::t('app', 'Import from excel'),
                        'toggleButton' => [
                            'label' => Yii::t('app', 'Import'), 'class' => 'btn btn-primary change-cover'
                        ],
                    ]);
                    $form = ActiveForm::begin(['options' => ['id' => 'upload-members', 'enctype' => 'multipart/form-data']]);
                    echo '<div id="import-errors"></div>';
                    echo $form->field($model, 'file')->widget(FileInput::classname(), $options);
                    echo Html::submitButton('Import now', ['id' => 'member-import-submit', 'class' => 'btn btn-success', 'data-loading-text' => "Loading..."]);
                    ActiveForm::end();
                    Modal::end();
                    ?>
                <?php endif; ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'options'=>['id'=>'imported-logs']
                ],
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> attendance-log </h3>',
                    'type' => 'primary'
                ],
                'columns' => [
                    'id',
                    "uid" => ["label" => "UserName", "format" => "raw", "value" => function($model) {
                            return Html::a(Html::encode($model->user->username), ["/admin-manage-users/view", "id" => $model->user->id]);
                        }],
                    'start_titme',
                    'end_time',
                    'duration',
                    'date',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => Helper::filterActionColumn('{view} {update} {delete} '),
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
