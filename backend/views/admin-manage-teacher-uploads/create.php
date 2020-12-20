<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeacherUpload */

$this->title = 'Create Teacher Upload';
$this->params['breadcrumbs'][] = ['label' => 'Teacher Uploads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-upload-create">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'classes' => $classes,
                'file_options'=>$file_options
            ])
            ?>
        </div>
    </div>
</div>
