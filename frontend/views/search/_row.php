<?php  
use \yii\helpers\StringHelper; 
use \frontend\helpers\CustomUrl;
?>
<div class="col-sm-4 pull-right">
    <div class="block-content">
        <div class="block-content">
            <div class="block-image-wrap">
                <div class="block-image">
                    <a href="<?= $model['url'] ?>"><img src="<?=  $model['image']?>"></a>
                </div>
                <div class="extra-title"><?= $model['type'] ?> </div><span></span>
            </div>
            <div class="block-desc">

                <a href="<?= $model['url'] ?>"><div class="block-title bold"><?= $model['title'] ?></div></a>
                <div class="block-date"><?= $model['created'] ?></div>
                <div class="block-body"> <?= StringHelper::truncate($model['description'], '70','...'); ?></div> 
            </div>
        </div>
    </div>
</div>