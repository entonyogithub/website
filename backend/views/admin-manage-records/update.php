<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Syllabus */

$this->title = 'Update Record: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Syllabi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="syllabus-update">

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
