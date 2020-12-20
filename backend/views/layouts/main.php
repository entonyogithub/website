<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'main-login', ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    //dmstr\web\AdminLteAsset::register($this);
    springdev\urban\assets\UbranAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/springdev/urban/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>
        <body>
            <?php $this->beginBody() ?>
            <div class="app layout-fixed-header">

                <?=
                $this->render(
                        'left.php', ['directoryAsset' => $directoryAsset]
                )
                ?>
                <div class=main-panel>
                    <?=
                    $this->render(
                            'header.php', ['directoryAsset' => $directoryAsset]
                    )
                    ?>
                    <div class=main-content>
                        <?=
                        Breadcrumbs::widget(
                                [
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]
                        )
                        ?>
                        <?= \frontend\widgets\Alert::widget() ?>
                        <?= $content ?>
                    </div>    
                </div>
                <?=
                $this->render(
                        'footer.php', ['directoryAsset' => $directoryAsset]
                )
                ?>
               <?php // \backend\widgets\ChatBox::widget(); ?>
            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>