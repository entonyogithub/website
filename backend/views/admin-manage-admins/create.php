<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create Admin';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="panel mb25">

        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'profile' => $profile,
                'photo_options' => $photo_options,
            ])
            ?>
        </div>
    </div>
</div>
