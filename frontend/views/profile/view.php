<?php

use \yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

\kop\y2sp\assets\InfiniteAjaxScrollAsset::register($this);
$this->title = Yii::$app->name . '-' . Yii::t('app', 'My profile');
$recommendor = Yii::$app->user->id ? Yii::$app->user->id : '';
?>
<?php $this->registerJs("
    jQuery(document.body).on('click', '.open-comments-container', function(event) {
        $(this).parent().find('.post-comments-container').removeClass('hide');
        return false;
    });
    $('#recomment-btn').click(function(){
    $(this).addClass('hide');
    $('#recommendation-form').removeClass('hide');
    })
    $('body').on('beforeSubmit', 'form#recommendation-form', function() {
    var form = $(this);
    if (form.find('.has-error').length) {
      return false;
    }
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          dataType: 'json',
          data: form.serialize()+'&uid='+" . $user->id . ",   
          success: function (response) {
               if(response.success == 1){
               $('#recommendation-form').find('.alert').remove();
               $('#recommendation-form').prepend('<div class=\'alert alert-success\'>" . Yii::t('app', 'New recommendation added successfully') . "</div>')
               $('#recommendation-form')[0].reset();
               $.pjax.reload({container:'#RecommendationListView'});
               }else{
               $('#recommendation-form').find('.alert').remove();
               $('#recommendation-form').prepend('<div class=\'alert alert-danger\'>'+response.message+'</div>')
               }
              
          }
     });
     return false;
  });

$('.endorse-skill').click(function () {
    var url = $(this).attr('href');
    var link = $(this);
    $(this).button('loading')
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: 'uid=' + " . $user->id . ",
        success: function (response) {
         link.button('reset');
            if (response.success == 1) {
              var count_val =  link.parent().find('.count').text();
               link.parent().find('.count').text(parseInt(count_val)+1);
               link.parent().find('.count').removeClass('hide'); 
               link.parent().parent().find('.members').append('<span class=\'member\'><img src='+response.image+' /></span>') 
               link.remove();
            }
        }

    });
    return false;
}); 
//     $('#RecommendationListView').on('pjax:success', function(data,status,xhr) {
//     
//           w1_ias.reinitialize();
//            w1_ias.extension(new IASSpinnerExtension({'html': '<div class=\'ias-spinner\' style=\'text-align: center;\'><img src=\'{src}\'/></div>'}));
//            w1_ias.extension(new IASTriggerExtension({'text': 'المزيد من التوصيات', 'html': '<div class=\'custom-pagination\'><div class=\'btn btn-lg btn-more \'>{text}</div></div>', 'offset': 0}));       
//                });

 $('.info-block .contact-block').hover(
                    function () {
                        $(this).find('.contact-icons').show();
                       
                    },
                    function () {
                        $(this).find('.contact-icons').hide();
                       
                    }
            );

") ?>
<div class="user-profile-page  view-profile">
    <?= \yii\base\View::render('_profileHeader',['profile'=>$profile,'user'=>$user])?>
    <div class="container buffer">
        <div class="col-sm-10 ">
            <div class="brief-icon"></div><span class="bold  block-text">نبذة</span>
            <div class="autor-intro text-right"><?= $profile->bio; ?></div>
        </div>
    </div>
    <div class="white-bg">
        <div class="container">
            <div class="col-sm-10 top-buffer publications">
                <div class="publications-icon"></div><span class="bold  block-text"><?= Yii::t('app', 'My posts') ?></span>
                <div class="blocks-wrap">
                    <?php
                    \yii\widgets\Pjax::begin(['id' => 'PostsListView']);
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $posts,
                        'itemOptions' => ['class' => 'block col-sm-9 pull-right'],
                        'itemView' => '_eachPost',
                        'layout' => '{items}{pager}',
                        'pager' => [
                            'class' => \kop\y2sp\ScrollPager::className(),
                            'triggerText' => Yii::t('app', 'More recommendation'),
                            'triggerTemplate' => '<div class="custom-pagination"><div class="btn btn-lg btn-more ">{text}</div></div>',
                            'noneLeftText' => '',
                            'noneLeftTemplate' => '',
                        ]
                    ]);
                    \yii\widgets\Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="col-sm-10 top-buffer">


            <div class="education-icon"></div><span class="bold  block-text"><?= Yii::t('app', 'Education degree') ?></span>
            <div class="blocks-wrap clearfix">
                <?php if ($user->education): ?>
                    <?php foreach ($user->education as $education): ?>
                        <div class="block col-sm-8 pull-right" >
                            <div class="list"></div>
                            <div class="block-wrap">
                                <div class="block-title bold">
                                    <?= $education->qualification ?>
                                </div>
                                <div class="position">
                                    <?= $education->title ?>

                                </div>
                                <div class="date">
                                    <?= $education->to ?> / <?= $education->from ?>
                                </div>
                                <div class="body">
                                    <?= $education->desc ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="image-section experiences" style="background-image: url('<?= Url::to('@images'); ?>/profile-pic-2.png');">

        <div class="container">
            <div class="col-sm-10">
                <div class="expre-icon"></div><span class="bold  block-text">  <?= Yii::t('app', 'Experiences'); ?></span>
                <div class="blocks-wrap  clearfix">
                    <?php if ($user->experience): ?>
                        <?php foreach ($user->experience as $experience): ?>
                            <div class="block col-sm-8 pull-right" >
                                <div class="list"></div>
                                <div class="block-wrap">
                                    <div class="block-title bold">
                                        <?= $experience->occupation ?>      
                                    </div>
                                    <div class="position">
                                        <?= $experience->title ?>     

                                    </div>
                                    <div class="date">
                                        <?= $experience->to ?> / <?= $experience->from ?>
                                    </div>
                                    <div class="body">
                                        <?= $experience->desc ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-sm-10 top-buffer">
            <div class="skills">

                <div class="skilles-icon"></div><span class="bold  block-text"> <?= Yii::t('app', 'Skills'); ?> </span>
                <div class="blocks-wrap clearfix">

                    <?php if ($user->skill): ?>
                        <?php foreach ($user->skill as $skill): ?>
                            <div class="block-container col-xs-12 col-sm-10 pull-right clearfix ">
                                <div class="list"></div>
                                <div class="block">
                                    <?php if (Yii::$app->user->id && Yii::$app->user->id != $user->id): ?>
                                        <?php $exist = \common\models\SkillEndorsment::find()->where(['uid' => Yii::$app->user->id, 'user_skill_id' => $skill->id])->count() ?>
                                        <?php if ($exist == 0): ?>
                                            <?php
                                            echo Html::a(
                                                    '<span class="glyphicon  glyphicon-plus add"></span>', Url::to(['/home/add-endorsment', 'skill_id' => $skill->id]), ['id' => 'endorse-skill-' . $skill->id, ' data-loading-text' => "...", 'class' => 'pull-right endorse-skill'])
                                            ?>
                                            <span class="count glyphicon hide"><?= $skill->endorsmentCount; ?></span>
                                        <?php else: ?>
                                            <span class="count glyphicon"><?= $skill->endorsmentCount; ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="block-title pull-right">
                                        <?= $skill->skill->name ?>
                                    </div>
                                </div>
                                <div class="members pull-left">
                                    <span class="member">
                                        <?php foreach ($skill->endorsment as $endorsment): ?>
                                            <img src="<?= \yii\helpers\Url::to(Yii::$app->params['image']['w90x90']['url']) . '/' . $endorsment->user->profile->photo ?>" />
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="white-bg">
        <div class="container">
            <div class="col-sm-10 top-buffer">


                <div class="recommendations-icon"></div><span class="bold  block-text"><?= Yii::t('app', 'Recommendation') ?></span>
                <div class="blocks-wrap  clearfix">
                    <?php
                    \yii\widgets\Pjax::begin(['id' => 'RecommendationListView']);
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $recommendation,
                        'itemOptions' => ['class' => 'item block col-sm-8 pull-right'],
                        'itemView' => '_eachRecommendation',
                        'layout' => '{items}{pager}',
                        'pager' => [
                            'class' => \kop\y2sp\ScrollPager::className(),
                            'triggerText' => Yii::t('app', 'More recommendation'),
                            'triggerTemplate' => '<div class="custom-pagination"><div class="btn btn-lg btn-more ">{text}</div></div>',
                            'noneLeftText' => '',
                            'noneLeftTemplate' => '',
                        ]
                    ]);
                    \yii\widgets\Pjax::end();
                    ?>

                </div>
                <div class="col-sm-10 pull-right">
                    <button id="recomment-btn" class="btn btn-colored"><?= Yii::t('app', 'Add recommendation') ?></button>
                    <?php
                    $form = ActiveForm::begin(['id' => 'recommendation-form',
                                'action' => \yii\helpers\Url::to('/home/add-recommendation'),
                                'enableClientValidation' => true,
                                'options' => ['class' => 'comment-content pull-right form hide']]);
                    ?>
                    <?= $form->field($new_recommendation, 'recommendation')->textarea(['maxlength' => true, 'class' => 'form-control initiative-desc', 'placeholder' => Yii::t('app', 'Add recommendation')])->label('') ?>
                    <?= Html::submitButton(yii::t('app', 'Send Recommendation'), ['class' => 'btn  btn-colored']) ?>
                    <?php ActiveForm::end(); ?>  
                </div>

            </div>
        </div>
    </div>

</div>
