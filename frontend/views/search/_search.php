<?php 
use yii\bootstrap\ActiveForm; 
$types = [
    1 => Yii::t('app', 'Complaints'), 
    2 => Yii::t('app', 'Events'),
    3 => Yii::t('app', 'Initiatives'),
    4 => Yii::t('app', 'Projects')
    ];
 $keyword = isset(Yii::$app->request->get('SearchSite')['keyword']) ? Yii::$app->request->get('SearchSite')['keyword'] : '';
?>
<div class="event-form">
        <?php $form = ActiveForm::begin(['id'=>'search-form','action'=>  \yii\helpers\Url::to('/search/index'),'method'=>'get']); ?>
    <div class="dropdown pull-right col-md-8 text-right">
    <?= \yii\helpers\Html::activeDropDownList($search, 'type',$types, ['prompt' => Yii::t('app', 'All'), 'class' => 'btn dropdown-btn dropdown-toggle']); ?>
        <?= \yii\helpers\Html::activeHiddenInput($search, 'keyword',['value'=>$keyword]); ?>
    </div>

<?php ActiveForm::end(); ?>
</div>