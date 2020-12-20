 <?php $this->title = Yii::$app->name . '-' . Yii::t('app','Search result');?> 
<?php $this->registerJs('
        $("#searchsite-type").change(function(){
        var form = $("#search-form");
        form.submit();
//         $.pjax.reload({url:form.attr("action"),data:form.serialize(),container:"#searchListView"});
        });
        ') ?>
<div  class="container"> 
    <div class="intro-text-wrap">
        <div class="intro-text">
            <?= Yii::t('app', 'Search result') ?>

        </div>

    </div>
    <div class="page-header">

         <?= yii\base\View::render('_search', ['search' => $search]); ?>
    </div>
    <div class="row">
        <?php
        echo \yii\widgets\ListView::widget([
            'dataProvider' => $results,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_row',
            'layout' => '{items}{pager}',
            'pager' => [
                'class' => \kop\y2sp\ScrollPager::className(),
                'triggerText' => Yii::t('app', 'More'),
                'triggerTemplate' => '<div class="custom-pagination"><div class="btn btn-lg btn-more ">{text}</div></div>',
                'noneLeftText' => '',
                'noneLeftTemplate' => '',
            ]
        ]);
        ?>
    </div>
</div>