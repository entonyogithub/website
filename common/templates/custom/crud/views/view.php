<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\detail\DetailView;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <div class="panel mb25">
        <div class="panel-body">
            <p>
                <?= "<?php "; ?>if (Helper::checkRoute('update')): <?= "?>\n"; ?>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) ?>
                <?= "<?php"; ?> endif; <?= "?>\n"; ?>
                <?= "<?php "; ?> if (Helper::checkRoute('delete')): <?= "?>\n"; ?>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
                ],
                ]) ?>
                <?= "<?php"; ?> endif; <?= "?>\n"; ?>
            </p>
            <?= "<?= " ?>DetailView::widget([
		'model'=>$model,
                'bordered' => true,
    		'panel' => [
     		'heading' => $model->id,
      	        'type' => DetailView::TYPE_PRIMARY,
//              'headingOptions' => ['template' => '{title}']
    ],
    'hAlign' => DetailView::ALIGN_LEFT,
            'attributes' => [
            <?php
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    echo "            '" . $name . "',\n";
                }
            } else {
                foreach ($generator->getTableSchema()->columns as $column) {
                    $format = $generator->generateColumnFormat($column);
                    if ($column->name != 'df') {
                        if ($column->name == 'logo' || $column->name == 'image' || $column->name == 'photo') {
                            echo ' "'.$column->name .'" => ["label" => "'. ucfirst($column->name).'", "format" => "raw", "value" => \branchonline\lightbox\Lightbox::widget([
                                        "files" => [
                                            [
                                                "thumb" => $model->getUploadUrl("'.$column->name .'"),
                                                "original" => $model->getUploadUrl("'.$column->name .'"),
                                                "thumbOptions" => ["width" => "200px"]
                                            ],
                                        ]
                            ])],'."\n";
                        } else {
                            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        }
                    }
                }
            }
            ?>
            ],
            ]) ?>
        </div>
    </div>
</div>
