<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    <?php if(in_array('logo', array_values($generator->getColumnNames())) || in_array('photo', array_values($generator->getColumnNames())) || in_array('image', array_values($generator->getColumnNames()))) : ?>
     <?= "<?php " ?>$form = ActiveForm::begin(['enableClientValidation' => false, 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php else:?>
        <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    <?php endif; ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        if($attribute != 'df' &&  $attribute != 'created_at' && $attribute != 'updated_at' && $attribute != 'uid'){
            if($attribute == 'photo' || $attribute == 'logo' || $attribute == 'image'){
                echo ' <?= $form->field($model, "'.$attribute.'")->widget(\kartik\file\FileInput::classname(), [
                            "options" => ["multiple" => false, "accept" => "image/*"],
                            "pluginOptions" => $'.$attribute.'_options
                        ]);'. " ?>\n\n";
            }else
             echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
        }
    }
} ?>
    <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
