<h1>Update My Password</h1>
<br>
<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'update-user']); ?>

<?= $form->field($model, 'oldPassword')->passwordInput() ?>
<?= $form->field($model, 'newPassword')->passwordInput() ?>
<?= $form->field($model, 'repeatPassword')->passwordInput() ?>


<div class="form-group">
    <?= Html::submitButton('Update password', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
</div>

<?php ActiveForm::end(); ?>