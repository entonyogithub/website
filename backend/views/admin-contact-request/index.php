<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contact Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-request-index">



    <p>
        <?= Html::a('Create Contact Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{items}{pager}<div class="pull-right">{summary}</div>',
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                ],
                'columns' => [
                    'id',
                    'name',
                    'email:email',
                    'subject:ntext',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
