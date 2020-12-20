<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Syllabus */

$this->title = 'Create Syllabus';
$this->params['breadcrumbs'][] = ['label' => 'Syllabi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syllabus-create">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                 'classes' => $classes,
            ])
            ?>
        </div>
    </div>
</div>
