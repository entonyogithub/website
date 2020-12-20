<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <div class="panel mb25">
        <div class="panel-body">
            <?php if (!empty($generator->searchModelClass)): ?>
                <?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php endif; ?>
            <p>
                <?= "<?php "; ?>if (Helper::checkRoute('create')): <?= "?>\n"; ?>
                <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
                <?= "<?php"; ?> endif; <?= "?>\n"; ?>
            </p>
            <?php if ($generator->indexWidgetType === 'grid'): ?>
                <?= "<?= " ?>GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'pjaxSettings' => [
                'neverTimeout' => true,
                ],
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th"></i> <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?> </h3>',
                    'type' => 'primary'
                ],
                <?= !empty($generator->searchModelClass) ? "'columns' => [\n" : "'columns' => [\n"; ?>

                <?php
                $count = 0;
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    
                    foreach ($generator->getColumnNames() as $name) {
                            if (++$count < 6) {
                                echo "            '" . $name . "',\n";
                            } else {
                                echo "            // '" . $name . "',\n";
                            }
                    }
                } else {
                    foreach ($tableSchema->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        if ($column->name != 'df'){
                         if ($column->name == 'uid' || $column->name =='created_at' || $column->name =='updated_at') {
                                                  
                            if($column->name == 'uid'){
                                
                                echo ' "uid" => ["label" => "Created by", "format" => "raw", "value" => function($model) {
                                                    return Html::a(Html::encode($model->user->email), ["/admin-user/view", "id" => $model->user->id]);
                                                    }],'."\n";
                                
                            }
                            if($column->name == 'created_at' || $column->name == 'updated_at'){
                            echo "            '" . $column->name . ":datetime',\n";}
                        }else{
                              if (++$count < 6) {
                            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        } else {
                            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                        }
                        }
                    }
                    }
                }
                ?>

                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => Helper::filterActionColumn('{view} {update} {delete} '),
                ],
                ],
                ]); ?>
            <?php else: ?>
                <?= "<?= " ?>ListView::widget([
                'dataProvider' => $dataProvider,
                'layout'=>'{items}{pager}<div class="pull-right">{summary}</div>',
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                },
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
