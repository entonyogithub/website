<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\IamInMember */

$this->title = 'Update Iam In Member: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Iam In Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="iam-in-member-update">

    <div class="panel mb25">
        <div class="panel-body">

            <?= $this->render('_form', [
            'model' => $model,
                                     
                                    
                                    
                                    
                                    
                                    
                                    
                        ]) ?>
        </div>
    </div>
</div>
