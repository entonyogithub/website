<?php $this->title = Yii::$app->name . '-' . $model->title; ?>
<?php
/* @var $this yii\web\View */
?>
<div class="container text-right text-page">
    <div class="col-sm-10">
        <h1><?= $model->title; ?></h1>
        <div class="body">
            <?= $model->description; ?>
        </div>
    </div>

</div>
