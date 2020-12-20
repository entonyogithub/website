<?php
/* @var $this yii\web\View */

use miloschuman\highcharts\Highstock;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\bootstrap\Html;

$this->title = 'Dashboard';
?>
<?php $this->registerJs('
    $("#upload-audio").on("beforeSubmit", function (event) {
    $("#upload-audio-submit").button("loading");
    var formData = new FormData($("#upload-audio")[0]);
    file = document.getElementById("studentupload-file").files[0];
    var reader = new FileReader();
    var duration = ' . $class->class->recording_duration . '
    formData.append("duration",duration);
    $.ajax({
            method:"post",
            dataType:"json",
            url: "/admin/admin-user-dashboard/upload",
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(response){
            $("#upload-errors").removeClass("alert alert-error")
            $("#upload-errors").empty()
            $("#upload-audio-submit").button("reset");
            if(response.success == 1){
             $("#upload-modal").modal("hide");
             $("#upload-audio")[0].reset();
             $.pjax.reload({container:"#student-uploads-view"});
            }else{
             $("#upload-errors").addClass("alert alert-danger")
             $("#upload-errors").append(response.error)
             }
            }
       });
     return false;
    });  
      
        ', yii\web\View::POS_READY) ?>

<div class="site-index">
    <div class="row">
        <div class="col-xs-12">
            <?php if ($class->class->minimum_uploads > $user_uploads_count): ?>
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <h4> You must record the minimum amount of required material.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></h4>
                </div>
            <?php endif; ?>
            <?php if ($class->class->minimum_listening > $user_listening_count): ?>
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <h4>You must listen to the minimum numbers of audio segments .
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
            <?php endif; ?>
            <?php if ($class->class->show_payment): ?>
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <h4><strong>Payment!</strong>Your payments are do on <?= date('M'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></h4>
                </div>
            <?php endif; ?>
            <div class="panel mb25">
                <div class="panel-body">
                    <?php if ($class->class->enable_iam_in && !$IamInMember_exist && ($user_uploads_count >= $class->class->iam_in_uploads || $user_listening_count >= $class->class->iam_in_listenings)): ?>
                        <div class="alert alert-success alert-dismissible show" role="alert">
                            <h4 class="alert-heading">Congratulation <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></h4>
                            You have been selected to join our weekly meeting on Friday. Are you coming ?
                            <hr>
                            <?php $form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
                            <?= $form->field($iamInForm, 'class_id')->hiddenInput(['value' => $class->class_id])->label(false); ?>
                            <?= $form->field($iamInForm, 'uid')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>
                            <?= Html::submitButton('Yes', ['name' => "submit-btn", 'value' => 'yes', 'class' => 'btn btn-success']) ?>
                            <?= Html::submitButton('No', ['name' => "submit-btn", 'value' => 'no', 'class' => 'btn btn-danger']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    <?php endif; ?>
                    <?=
                    kartik\tabs\TabsX::widget([
                        'enableStickyTabs' => true,
                        'position' => kartik\tabs\TabsX::POS_ABOVE,
                        'bordered' => true,
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'label' => '<i class="glyphicon glyphicon-dashboard"></i> Dashboard',
                                'content' => $this->render('_chat', [
                                    "class" => $class,
                                    'upload' => $upload,
                                    'options' => $options,
                                    'student_uploads' => $student_uploads,
                                    'user_uploads_count' => $user_uploads_count,
                                    'user_listening_count' => $user_listening_count
                                ]),
                            ],
                            [
                                'label' => '<i class="glyphicon glyphicon-user"></i> Teacher Uploads',
                                'content' => $this->render('_teacher', ['teacher_uploads' => $teacher_uploads]),
                            //'linkOptions' => ['data-url' => Url::to(['/admin-campaign/view','id'=>(string)$model->_id, 'tab' => 2])]
                            ],
                        ]
                            ]
                    );
                    ?>
                    <div class="col-sm-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
