<?php

use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$role = Yii::$app->user->identity->role;
$controller_id = Yii::$app->controller->id;
?>
<div class="sidebar-panel offscreen-left">
    <div class=brand>
        <div class=brand-logo> <img src="<?= Url::to('/admin/images/logo.png') ?>" height=15 alt=""> </div>
        <a href=javascript:; class="toggle-sidebar hidden-xs hamburger-icon v3" data-toggle=layout-small-menu> <span></span> <span></span> <span></span> <span></span> </a>   
    </div>
    <nav role=navigation>
        <ul class=nav>
            <?php if ($role == 'Users'): ?>  
                <li> <a href="<?= \yii\helpers\Url::to(["/admin-user-dashboard"]) ?>"> <i class="fa fa-flask"></i> <span>Dashboard</span> </a> </li>
                <li class=" <?php $controller_id == 'admin-user-dashboard' ? print 'open' : '' ?>">
                    <a href=javascript:;> <i class="fa fa-users"></i> <span>Menu</span> </a> 
                    <?php
                    $span = '';
                    if ($count = common\models\Message::find()->where(['uid' => Yii::$app->user->id, 'read' => \common\models\Enum::ANSWER_NO, 'type' => \common\models\Message::MESSAGE_ADMIN])->count())
                        $span = "<span class='red-circle2'>$count</span>";
                    ?>
                    <ul class=sub-menu>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/profile']) ?>"><span>Profile</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/assignments']) ?>"><span>Assignments</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/syllabus-records']) ?>"><span>Syllabus</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/payments']) ?>"><span>Payments</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/best-students']) ?>"><span>Top Students</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/messages']) ?>"><span>Message to admin </span><?= $span ?></a></li>
                         <li><a href="<?= \yii\helpers\Url::to(['/admin-user-dashboard/attendance']) ?>"><span>Attendance Log</span></a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if ($role == 'Admins' || $role == 'Administrators' || $role == 'Teachers'): ?>  
                <li> <a href="<?= \yii\helpers\Url::to(["/admin-dashboard"]) ?>"> <i class="fa fa-flask"></i> <span>Dashboard</span> </a> </li>
            <?php endif; ?>
            <?php if ($role == 'Admins' || $role == 'Administrators'): ?>  
                <li class=" <?php $controller_id == 'admin-manage-admins' || $controller_id == 'admin-manage-administrators' || $controller_id == 'admin-manage-users' || $controller_id == 'admin-manage-teachers' ? print 'open' : '' ?>">
                    <a href=javascript:;> <i class="fa fa-users"></i> <span>Manage Users</span> </a> 
                    <ul class=sub-menu>
                        <?php if ($role == 'Admins'): ?>
                            <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-admins/index']) ?>"><span></span>Admins</a></li>
                        <?php endif; ?>
                        <?php if ($role == 'Admins' || $role == 'Administrators'): ?>   
                            <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-administrators']) ?>"><span>Administrators</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-teachers']) ?>"><span>Teachers</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-users']) ?>"><span>Users</span></a></li>
                        <?php endif; ?>
                        
                    </ul>
                </li>
            <?php endif; ?>
            <?php if ($role == 'Admins' || $role == 'Administrators' || $role == 'Teachers'): ?>  
                <li class="open">
                    <a href=javascript:;> <i class="fa fa-list"></i> <span>Content</span> </a> 
                    <ul class=sub-menu>

                        <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-classes']) ?>"><span>Classes</span></a></li>
                        <?php if ($role == 'Admins' || $role == 'Administrators'): ?>  
                            <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-attendance-logs']) ?>"><span>Attendance Logs</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-records']) ?>"><span>Syllabus</span></a></li>
                        <?php endif; ?>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-teacher-uploads']) ?>"><span>Teacher Uploads</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-class-syllabus']) ?>"><span>Syllabus for class</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-iam-in-member']) ?>"><span>I am In Members</span></a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-manage-assignments']) ?>"><span>Assignments</span></a></li>

                       
                    </ul>
                </li>
            <?php endif; ?>
            <?php if ($role == 'Admins' || $role == 'Administrators'): ?>  
                <li class="<?php
                ($controller_id == 'admin-setting' || $controller_id == 'admin-oauth-client' || $controller_id == 'assignment' || $controller_id == 'permission' || $controller_id == 'role' || $controller_id == 'route' || $controller_id == 'rule') ? print 'open' : ''
                ?>">
                    <a href=javascript:;> <i class="fa fa-server"></i> <span>Spring Settings</span> </a>
                    <ul class=sub-menu>
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-oauth-client']) ?>"><span class="fa fa-key"></span> Oauth client</a></li>    
                        <li><a href="<?= \yii\helpers\Url::to(['/admin-setting']) ?>"><span class="fa fa-wrench"></span> Configurations</a></li>    
                        <?php if ($role == 'Admins'): ?>
                            <li><a href="<?= \yii\helpers\Url::to(['/gii']) ?>"><span class="fa fa-file-code-o"></span> Gii</a></li>
                            <li><a href="<?= \yii\helpers\Url::to(['/debug']) ?>"><span class="fa fa-dashboard"></span> Debug</a> </li>
                            <li class="open">
                                <a href=javascript:;> <i class="fa fa-wrench"></i> <span>Rights</span> </a>
                                <ul class=sub-menu>
                                    <li><a href="<?= \yii\helpers\Url::to(['/rights/assignment']) ?>"><i class="fa fa-circle-o">Assignment</i></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['/rights/permission']) ?>"><i class="fa fa-circle-o">Permission</i></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['/rights/role']) ?>"><i class="fa fa-circle-o">Role</i></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['/rights/route']) ?>"><i class="fa fa-circle-o">Route</i></a></li>
                                    <li><a href="<?= \yii\helpers\Url::to(['/rights/rule']) ?>"><i class="fa fa-circle-o">Rule</i></a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>