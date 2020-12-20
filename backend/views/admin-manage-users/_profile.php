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
         <?= $form->field($profile, 'date_of_birth')->textInput()->hint("Date format Y-m-d. example 1970-01-01") ?>
        <?= $form->field($profile, 'address')->textArea(['rows' => 6]) ?>
        <?= $form->field($profile, 'balance')->textInput() ?>
        <?= $form->field($profile, 'finger_print_id')->textInput() ?>
    </fieldset>
</div>