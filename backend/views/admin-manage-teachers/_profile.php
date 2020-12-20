<?php

use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
?>
<div id="profile-info">
    <fieldset>
        <legend>Profile Information</legend>
        <?= $form->field($profile, 'first_name')->textInput() ?>
        <?= $form->field($profile, 'last_name')->textInput() ?>
        <?= $form->field($profile, 'mobile')->textInput() ?>
    </fieldset>
</div>