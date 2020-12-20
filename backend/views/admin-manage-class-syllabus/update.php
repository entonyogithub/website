<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ClassSyllabus */

$this->title = 'Update Class Syllabus: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Class Syllabi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="class-syllabus-update">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'classes' => $classes,
                'records' => $records,
            ])
            ?>
        </div>
    </div>
</div>
