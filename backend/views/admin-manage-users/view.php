<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-view">
    <div class="panel mb25">
        <div class="panel-body ">
            <?=
            kartik\tabs\TabsX::widget([
                'enableStickyTabs' => true,
                'position' => kartik\tabs\TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => '<i class="glyphicon glyphicon-dashboard"></i> User Details',
                        'content' => $this->render('_view', ['model' => $model]),
                    ],
                    [
                        'label' => '<i class="glyphicon glyphicon-usd"></i> User Payments',
                        'content' => $this->render('_payments', ['model' => $model,'payments'=>$payments]),
                    ],
                    [
                        'label' => '<i class="glyphicon glyphicon-record"></i> User Recordings',
                        'content' => $this->render('_recordings', ['model' => $model,'uploads' => $uploads]),
                    ],
                     [
                        'label' => '<i class="glyphicon glyphicon-headphones"></i> Listenings',
                        'content' => $this->render('_listenings', ['model' => $model,'listenings' => $listenings]),
                    ],
                     [
                        'label' => '<i class="glyphicon glyphicon-list"></i> Attendance Logs',
                        'content' => $this->render('_logs', ['model' => $model,'logs' => $logs]),
                    ],
//                    [
//                        'label' => '<i class="glyphicon glyphicon-user"></i> Contacts',
//                        'content' => $this->render('_contacts', ['model' => $model, 'contacts' => $contacts]),
//                    //'linkOptions' => ['data-url' => Url::to(['/admin-campaign/view','id'=>(string)$model->_id, 'tab' => 2])]
//                    ],
//                    [
//                        'label' => '<i class="glyphicon glyphicon-camera"></i> Favourites',
//                        'content' => $this->render('_fav', ['model' => $model, 'favourites' => $favourites]),
//                    //'linkOptions' => ['data-url' => Url::to(['/admin-campaign/view','id'=>(string)$model->_id, 'tab' => 2])]
//                    ],
                ]
                    ]
            );
            ?>
        </div>
    </div>
</div>
