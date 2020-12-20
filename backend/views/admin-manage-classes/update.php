<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentClass */

$this->title = 'Update Student Class: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Student Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-class-update">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
</div>
