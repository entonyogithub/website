<?php

use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?php echo $this->render('meta'); ?>
<?php $this->head() ?>
    </head>
    <body>
            <?php $this->beginBody() ?>
        <div class="wrap">
                <?php echo $this->render('app_header'); ?>
            <section id="main">
<?= $content ?>
            </section>
        </div>

        <?php echo $this->render('footer'); ?>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
