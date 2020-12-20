<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherUpload */

$this->title = 'Update Teacher Upload: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Teacher Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="teacher-upload-update">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'classes' => $classes,
                'file_options' => $file_options
            ])
            ?>
        </div>
    </div>
</div>
