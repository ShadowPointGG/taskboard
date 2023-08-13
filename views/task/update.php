<?php

use app\models\usermodels\User;
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
    'options' => [
            'placeholder' => 'Enter the date this task is due ....',
        'value'=> date('m/d/Y',$model->task_due)
    ],
    'pluginOptions' => [
        'autoclose' => true,
    ],
]);?>
    <br>
<?php
if(!empty($assignments)) {
    $currentAssign = "Currently assigned to: ";
    foreach ($assignments as $assignee) {
        $currentAssign .= User::getUsername($assignee['user_id']);
    }
    echo $currentAssign;
}else{
    echo "Task not currently assigned!";
}
?>
    <br><br>
<?= $form->field($assignment, 'user_id')->dropDownList(ArrayHelper::map($users,'id','username'),['multiple'=>'multiple'])?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>