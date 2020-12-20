<?php

use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
?>
<div id="profile-info">
    <fieldset>
        <legend>Admin Information</legend>
        <?php /*
        $form->field($profile, 'photo')->widget(\kartik\file\FileInput::classname(), [
            'options' => ['multiple' => false, 'accept' => 'image/*'],
            'pluginOptions' => $photo_options
        ]); */
        ?>
        <?= $form->field($profile, 'name')->textInput() ?>
        <?= $form->field($profile, 'mobile')->textInput() ?>
        <?=
        $form->field($profile, 'date_of_birth')->widget(
                \dosamigos\datepicker\DatePicker::className(), [
            // inline too, not bad
            // modify template for custom rendering
            'template' => '{addon}{input}',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>
    </fieldset>
</div>