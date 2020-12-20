<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create Teacher';
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="panel mb25">

        <div class="panel-body">

            <?=
            $this->render('_form', [
                'model' => $model,
                'profile' => $profile
            ])
            ?>
        </div>
    </div>
</div>
