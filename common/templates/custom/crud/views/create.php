<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

    <div class="panel mb25">
        <div class="panel-body">

            <?= "<?= " ?>$this->render('_form', [
            'model' => $model,
            
             <?php foreach ($generator->getColumnNames() as $attribute): ?>
            <?php  if($attribute == 'photo' || $attribute == 'logo' || $attribute == 'image'): ?>
            '<?= $attribute ?>_options' => $<?= $attribute ?>_options,<?= "\n"; ?>
            <?php endif;?>
            
            <?php endforeach;?>
            ]) ?>
        </div>
    </div>
</div>
