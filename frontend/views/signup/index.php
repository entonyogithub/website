<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div  class="container user-profile-page  add-form form">
    <div class="intro-text-wrap col-sm-7 text-center">
        <div class="intro-text big-text">
            بمعنى ان الغايه هش  الشكل  وليس المعنى , هنا نص شكلي
        </div>

    </div>
    <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="container">
        <div class="col-sm-6">
            <div class="form-group form-file">
                <div class="file-wrap pull-left">
                    <div class="file-text">
                        تحديث الصورة
                    </div>
                    <?= Html::activeFileInput($profile, 'photo', ['class' => 'pull-left image_upload']); ?>
                </div>
                <img src="" class="file-logo pull-right" />
                <div class="has-error">
                    <?= Html::error($profile, 'photo', ['class' => 'error help-block help-block-error']); ?>
                </div>
            </div>
            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'Email')])->label(''); ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Password')])->label(''); ?>
            <?= $form->field($profile, 'name')->textInput(['placeholder' => Yii::t('app', 'Full name')])->label(''); ?>
            <?=
            $form->field($profile, 'date_of_birth')->widget(
                    \dosamigos\datepicker\DatePicker::className(), [
                // inline too, not bad
                // modify template for custom rendering
                'template' => '{addon}{input}',
                'clientOptions' => [
                    'autoclose' => true,
                    'placeholder' => 'asdasdas',
                    'format' => 'yyyy-mm-dd'
                ],
                'options' => ['placeholder' => Yii::t('app', 'Date Of Birth')]
            ])->label('');
            ?>
            <?= $form->field($profile, 'gender')->dropDownList(common\models\User::itemAlias('gender'), ['prompt' => Yii::t('app', 'Select Gender')])->label(''); ?>
            <?= $form->field($profile, 'mobile')->textInput(['placeholder' => Yii::t('app', 'Mobile')])->label(''); ?>
            <?= $form->field($profile, 'facebook_link')->textInput(['placeholder' => Yii::t('app', 'Facebook page')])->label(''); ?>
            <?= $form->field($profile, 'twitter_link')->textInput(['placeholder' => Yii::t('app', 'Twitter page')])->label(''); ?>
            <?= $form->field($profile, 'linkedin_link')->textInput(['placeholder' => Yii::t('app', 'Linked In')])->label(''); ?>
            <?= $form->field($profile, 'instagram_link')->textInput(['placeholder' => Yii::t('app', 'Instagram')])->label(''); ?>
            <?= $form->field($profile, 'city')->textInput(['placeholder' => Yii::t('app', 'City')])->label(''); ?>
            <?= $form->field($profile, 'country_id')->dropDownList($countries, ['prompt' => Yii::t('app', 'Select country')])->label(''); ?>

            <div class="pull-right">
                <?=
                $form->field($model, 'reCaptcha')->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha::className(), ['siteKey' => '6LdAcAkTAAAAAPCDfCDFOcYcommprpKq5pWN4u5I']
                )->label('');
                ?>
            </div>
            <div class="clearfix"></div>
            <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn  btn-colored', 'name' => 'signup-button']) ?>
            <?php ActiveForm::end(); ?>
            <div class="have-account"><a href="<?= \yii\helpers\Url::to('login') ?>"><?= Yii::t('app', 'Have account'); ?></a></div>


        </div>
    </div>
</div>