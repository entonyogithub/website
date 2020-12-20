<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
$notification = backend\helpers\CustomHelper::getNotifications();
$name = \yii::$app->user->identity->username;
$role = \yii::$app->user->identity->role;
?>
<header class="header navbar">
    <div class="brand visible-xs">
        <div class=toggle-offscreen> <a href="index.html#" class="hamburger-icon visible-xs" data-toggle=offscreen data-move=ltr> <span></span> <span></span> <span></span> </a> </div>
        <div class=brand-logo> <img src="<?php Url::to('/admin/images/logo.png') ?>" height=15 alt=""> </div>
        <ul class="nav navbar-nav navbar-right pull-right">
            <li>
                <a href=javascript:; data-toggle=dropdown><span class=pull-left><?= $name ?></span> </a> 
                <ul class=dropdown-menu>
                    <?php if ($role == 'Admins' || $role == 'Administrators'): ?>  
                        <li> <a href="<?= \yii\helpers\Url::to('/admin/admin-manage-administrators/profile') ?>">Profile</a> </li>
                    <?php endif; ?>
                    <li> <?=
                        Html::a(
                                'Sign out', ['/admin-dashboard/logout'], ['data-method' => 'post']
                        )
                        ?> </li>
                </ul>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav hidden-xs">
        <li>
            <p class=navbar-text> Welcome to” EnTonY’os Way ” Student Dashboard </p>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right hidden-xs">
        <li>
            <a href=javascript:; data-toggle=dropdown><span class=pull-left><?= $name ?></span> </a> 
            <ul class=dropdown-menu>
                <?php if ($role == 'Admins' || $role == 'Administrators'): ?>  
                    <li> <a href="<?= \yii\helpers\Url::to('/admin/admin-manage-administrators/profile') ?>">Profile</a> </li>
                <?php endif; ?>
                <li> <?=
                    Html::a(
                            'Sign out', ['/admin-dashboard/logout'], ['data-method' => 'post']
                    )
                    ?> </li>
            </ul>
        </li>
    </ul>
</header>