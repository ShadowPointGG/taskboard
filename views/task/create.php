<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$form = ActiveForm::begin([
    'id' => 'task-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $form->field($model, 'task_due')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter the date this task is due ....'],
    'pluginOptions' => [
        'autoclose' => true
    ],
]);?>
<?= $form->field($assignment, 'user_id')->dropDownList(ArrayHelper::map($users,'id','username'),['multiple'=>'multiple'])?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>