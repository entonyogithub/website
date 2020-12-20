<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ClassSyllabus */

$this->title = 'Create Class Syllabus';
$this->params['breadcrumbs'][] = ['label' => 'Class Syllabi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="class-syllabus-create">

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
