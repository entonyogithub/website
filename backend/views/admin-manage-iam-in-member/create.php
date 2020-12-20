<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\IamInMember */

$this->title = 'Create Iam In Member';
$this->params['breadcrumbs'][] = ['label' => 'Iam In Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iam-in-member-create">

    <div class="panel mb25">
        <div class="panel-body">

            <?= $this->render('_form', [
            'model' => $model,
            
                                     
                                    
                                    
                                    
                                    
                                    
                                    
                        ]) ?>
        </div>
    </div>
</div>
