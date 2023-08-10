<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="row">
<div class="col-md-3"></div>
    <div class="col-md-6">
<?php
echo "<h3>Setting password for: ".$user->email."</h3><br><br> ";
$form = ActiveForm::begin([
    'id' => 'set-password',
    'options' => ['class' => 'form-horizontal'],
]) ?>
<?= $form->field($model, 'newPassword') ?>
<?= $form->field($model, 'repeatPassword') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
    </div>
    <div class="col-md-3"></div>
</div>
