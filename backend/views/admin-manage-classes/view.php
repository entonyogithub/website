<?php
/* @var $this yii\web\View */
/* @var $model common\models\StudentClass */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Student Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerJs('     
      $("#add-user-form").on("beforeSubmit", function (event) {
        var form = $("#add-user-form");
         $.ajax({
         type:"POST",
          dataType:"json",
         url:form.attr("action"),
         data:form.serialize(),
         success:function(response){
         if(response.success == 1)
          $.pjax.reload({container:"#student-grid"});
          else
          $("#add-user-form #generl-error").removeClass("hide").find("p").text(response.error)
         }
         });
         return false;
        });
        
        $(document).on("pjax:success", function(data, content) {
        
        });
        
      $("#add-teacher-form").on("beforeSubmit", function (event) {
        var form = $("#add-teacher-form");
         $.ajax({
         type:"POST",
          dataType:"json",
         url:form.attr("action"),
         data:form.serialize(),
         success:function(response){
          if(response.success == 1)
          $.pjax.reload({container:"#teachers-grid"});
           else
          $("#add-teacher-form #generl-error").removeClass("hide").find("p").text(response.error)
         }
         });
         return false;
        });
        
        $(document).on("pjax:success", function(data, content) {
        
        });
'); ?>
<div class="student-class-view">

    <div class="panel mb25">
        <div class="panel-body">
            <?=
            kartik\tabs\TabsX::widget([
                'enableStickyTabs' => true,
                'position' => kartik\tabs\TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => '<i class="glyphicon glyphicon-dashboard"></i> Class Details',
                        'content' => $this->render('_view', ['model' => $model]),
                    ],
                    [
                        'label' => '<i class="glyphicon glyphicon-dashboard"></i> Teachers',
                        'content' => $this->render('_teacher', ['model' => $model,'teachers'=>$teachers,'addForm'=>$addForm]),
                    ],
                    [
                        'label' => '<i class="glyphicon glyphicon-user"></i> Students',
                        'content' => $this->render('_students', ['model' => $model,'students' => $students,'addForm'=>$addForm]),
                    ],
                     [
                        'label' => '<i class="glyphicon glyphicon-user"></i> Top Students',
                        'content' => $this->render('_topStudents', ['topStudents' => $topStudents]),
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
