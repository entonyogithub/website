<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AttendanceLog */

$this->title = 'Update Attendance Log: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attendance Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="attendance-log-update">

    <div class="panel mb25">
        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'users' => $users
            ])
            ?>
        </div>
    </div>
</div>
