<?php

use \yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name . '-' . Yii::t('app', 'Edit profile');
?>
<div class="container user-profile-page user-section">
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'form-edit-profile','scrollToError'=>false,'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-sm-2  pull-right user-profile-col">
            <div class="author-block">
                <div class="author-pic "><img src="<?= Url::to(Yii::$app->params['image']['w90x90']['url']) . '/' . $profile->photo; ?>"></div>
                <?= Html::activeFileInput($profile, 'photo', ['class' => 'pull-left protfile-image-btn image_upload']); ?>
                <div class="edit-pic"><a href="#"></a></div>
                <div class="edit-text"><?= Yii::t('app', 'Edit image'); ?></div>
            </div>
        </div>
        <div class="col-sm-10 pull-right grey-bg form ">
            <div class="page-header">
                <div class="page-title">
                    <?= Yii::t('app', 'My profile'); ?> 
                </div>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
            </div>
            <div class="form-wrap pull-right col-sm-8">
                <?= $form->field($profile, 'name')->textInput(); ?>
                <?=
                $form->field($profile, 'date_of_birth')->widget(
                        \dosamigos\datepicker\DatePicker::className(), [
                    // inline too, not bad
                    // modify template for custom rendering
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ]);
                ?>
                <?= $form->field($profile, 'gender')->dropDownList(common\models\User::itemAlias('gender'), ['prompt' => Yii::t('app', 'Select Gender')]); ?>
                <?= $form->field($model, 'email')->textInput(); ?>
                <?= $form->field($profile, 'mobile')->textInput(); ?>
                <?= $form->field($profile, 'facebook_link')->textInput(); ?>
                <?= $form->field($profile, 'twitter_link')->textInput(); ?>
                <?= $form->field($profile, 'linkedin_link')->textInput(); ?>
                <?= $form->field($profile, 'instagram_link')->textInput(); ?>
                <?= $form->field($profile, 'city')->textInput(); ?>
                <?= $form->field($profile, 'country_id')->dropDownList($countries, ['prompt' => Yii::t('app', 'Select country')]); ?>
                <?= $form->field($profile, 'bio')->textarea(['class'=>'form-control initiative-desc']); ?>
                <?= $form->field($profile, 'about')->textarea(['class'=>'form-control initiative-desc']); ?>


            </div>
            <hr class="pull-right">
            
            <div class="form-wrap pull-right col-sm-8">
                <?php //$form->field($profile, "about")->textarea(['class'=>'form-control initiative-desc','placeholder'=>  Yii::t('app','short bio')])->hint('شرح مختصر لا يتجاوز ال  كلمه'); ?>
                <div class="form-group degree">
                    <label for="degree"><?= Yii::t('app', 'Education degree') ?> </label>
                </div>
                <?=
                \mdm\widgets\TabularInput::widget([
                    'id' => 'education-container',
                    'allModels' => $model->education,
                    'modelClass' => common\models\UserEducation::className(),
                    'options' => ['tag' => 'div'],
                    'itemOptions' => ['tag' => 'div','class'=>'education-row'],
                    'itemView' => 'cv/_education',
                    'viewParams' => ['form' => $form],
                    'clientOptions' => [
                        'btnAddSelector' => '#add-education',
                        'btnDelSelector' => '#remove-education',
                        'afterAddRow' => new yii\web\JsExpression('function(){$(".date").datepicker({"autoclose":true,"format":"yyyy-mm-dd"});}'),
                    ]
                ]);
                ?>
                <div class="add-buttom degree ">
                    <div class="text"><?= Yii::t('app', 'Add education') ?></div>
                    <a id="add-education" href="#"></a>
                </div>
                <div class="form-group">
                <?= Html::label(Yii::t('app','Skills')); ?>
                <?= Html::dropDownList('skills',$user_skills,$skills,['class'=>'form-control-multi','multiple'=>'multiple']) ?>
                    <div class="desc text-right">*<?= Yii::t('app', 'You can select multiple') ?></div>
                </div>
                <div class="form-group degree">
                    <label for="degree"><?= Yii::t('app', 'Experiences') ?> </label>
                </div>
                <?=
                \mdm\widgets\TabularInput::widget([
                    'id' => 'experience-container',
                    'allModels' => $model->experience,
                    'modelClass' => common\models\UserExperience::className(),
                    'options' => ['tag' => 'div'],
                    'itemOptions' => ['tag' => 'div','class'=>'experience-row'],
                    'itemView' => 'cv/_experience',
                    'viewParams' => ['form' => $form],
                    'clientOptions' => [
                        'btnAddSelector' => '#add-experience',
                        'btnDelSelector' => '#remove-experience',
                        'afterAddRow' => new yii\web\JsExpression('function(){$(".date").datepicker({"autoclose":true,"format":"yyyy-mm-dd"});}'),
                    ]
                ]);
                ?>
                <div class="add-buttom degree ">
                    <div class="text"><?= Yii::t('app', 'Add experience') ?></div>
                    <a id="add-experience" href="#"></a>
                </div>
            </div>
            <div class="form-footer text-left pull-left">

                <div  class="btn btn-lg btn-more"><a href="#"><?= Yii::t('app', 'Cancel Account'); ?></a></div>
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>