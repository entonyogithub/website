<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update  ' . ' ' . $profile->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <div class="panel mb25">

        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
                'profile' => $profile,
                'photo_options' => $photo_options
            ])
            ?>
        </div>
    </div>
</div>
