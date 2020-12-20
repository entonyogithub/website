<section class="profile-timeline">
    <div class="profile-timeline-header">
        <div class="profile-timeline-user-details"> <a href="#" class="bold"><?= $model->user->userProfile->first_name." ".$model->user->userProfile->last_name ?></a>
            <div class='pull-right'><em class="text-aqua medium"><?= Yii::$app->formatter->asDate($model->created_at,"php:Y-m-.d h:i:s a") ?></em></div>
        </div>
    </div>
    <div class="profile-timeline-content">
        <div class="profile-timeline-audio clearfix">
            <audio controls id="test">
                <source src="<?= $model->getUploadUrl('file') ?>" type="audio/mpeg">
            </audio>
        </div>
    </div>
</section>