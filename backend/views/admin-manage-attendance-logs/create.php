<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AttendanceLog */

$this->title = 'Create Attendance Log';
$this->params['breadcrumbs'][] = ['label' => 'Attendance Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attendance-log-create">

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
