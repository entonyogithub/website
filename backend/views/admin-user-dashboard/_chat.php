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
<?php \yii\widgets\Pjax::begin(['id' => "student-uploads-view"]) ?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="widget bg-white">

            <div class="widget-icon bg-blue pull-left fa  fa-upload"> </div>
            <div class="overflow-hidden">
                <span class="widget-title"><?= $user_uploads_count . " / " . $class->class->total_number_of_recording ?></span>
                <span class="widget-subtitle" style="font-size: 16px;">Recordings</span>
            </div> 
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="widget bg-white">

            <div class="widget-icon bg-red pull-left fa  fa-headphones"> </div>
            <div class="overflow-hidden">
                <span class="widget-title"><?= $user_listening_count . " / " . $class->class->total_number_of_listening ?></span>
                <span class="widget-subtitle" style="font-size: 16px;">Listening</span>
            </div> 
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="widget bg-white">

            <div class="widget-icon bg-yellow pull-left fa  fa-tasks"> </div>
            <div class="overflow-hidden">
                <span class="widget-title"><?= $class->class->taken_lectures . ' / ' . $class->class->total_number_of_lectures ?></span>
                <span class="widget-subtitle" style="font-size: 16px;">Lectures</span>
            </div> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div id="chat-scroll"class="chat-scroll">

            <?php
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $student_uploads,
                'itemOptions' => ['class' => 'item profile-timeline'],
                'itemView' => '_row',
                'layout' => '{items}{pager}',
                'options' => ['class' => 'list-view col-sm-12'],
                'pager' => [
                    'prevPageLabel' => 'Previous',
                    'nextPageLabel' => 'Next',
                    'pageCssClass' => "page-style",
                    'linkOptions' => ['class' => 'mylink'],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
<?php \yii\widgets\Pjax::end(); ?>
<div class="row"> <div class="col-xs-12">
        <section class=" upload-buttons">

            <div class="composer-options">
                <fieldset>
                    <legend>Audio Recorder</legend>
                    <div id="upload-errors"></div>
                    <div id="recordingsList"></div>
                    
                    <div id="controls">
                        <button id="recordButton"  class="btn btn-danger">Record</button>
                        <button id="pauseButton" disabled  class="btn btn-danger">Pause</button>
                        <button id="stopButton" disabled  class="btn btn-danger">Stop</button>
                        <div  style="display: inline;"><i class="glyphicon glyphicon-time"></i> <span class="js-timeout">00:00</span></div>
                        <div id="upload-container" ></div>
                        <div id="progress" class="progress hide">
                            <div  class="progress-bar progress-bar-success" role="progressbar"  aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </fieldset>


                <?php /*
                  Modal::begin([
                  'id' => 'upload-modal',
                  'header' => Yii::t('app', 'Upload Audio File'),
                  'toggleButton' => [
                  'label' => '<i class="fa fa-upload"></i>', 'class' => 'btn btn-default btn-large'
                  ],
                  ]);
                  $form = ActiveForm::begin(['options' => ['id' => 'upload-audio', 'enctype' => 'multipart/form-data']]);
                  echo '<div id="upload-errors"></div>';
                  echo $form->field($upload, 'file')->widget(FileInput::classname(), $options);
                  echo "<audio id='audio'></audio>";
                  echo Html::hiddenInput("class_id", $class->class_id);
                  echo Html::submitButton('Upload Now', ['id' => 'upload-audio-submit', 'class' => 'btn btn-success', 'data-loading-text' => "Loading..."]);
                  ActiveForm::end();
                  Modal::end(); */
                ?>

            </div>
        </section>
    </div>
</div>
