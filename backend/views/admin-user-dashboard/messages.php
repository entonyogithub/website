<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ContactRequest */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel mb25">
    <div class="panel-body">
        <div class="">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div id="messages-container">      
                        <?php if ($messages): ?>
                            <?php foreach ($messages as $item): ?>
                                <?php if ($item->type == common\models\Message::MESSAGE_USER): ?>
                                    <div class="driver-chat-item admin-message">
                                        <div class="driver-chat-message">
                                            <div>
                                                <div>
                                                    <strong><?= $item->user->username; ?>:<span class="pull-right"><?= Yii::$app->formatter->asDate($item->created_at, 'php:Y-m-d H:i:s') ?></span></strong>
                                                </div>
                                               <div style="clear: both"> <?= $item->message; ?></div></div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="driver-chat-item user-message">
                                        <div class="driver-chat-message">
                                            <div>
                                                <div>
                                                    <strong>Admin:<span class="pull-right"><?= Yii::$app->formatter->asDate($item->created_at, 'php:Y-m-d H:i:s') ?></span></strong>
                                                </div>
                                                <div style="clear: both"> <?= $item->message; ?></div></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($message, 'message')->textInput(['maxlength' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?> 
                </div>
            </div>

        </div>
    </div>

</div>
