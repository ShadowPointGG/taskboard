<h1>Update My Profile</h1>
<br>
<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Authentication as authy;

If(authy::isUserAdmin()){
    include("access_rights.php");
    if(!empty($accessRights)) {
        echo Html::a('Clear Roles',['user/clear-roles','id'=>$model->id]);
    }
    echo "<hr>";
}

$form = ActiveForm::begin(['id' => 'update-user']); ?>

<?= $form->field($model, 'username')->textInput(['disabled' => !authy::isUserAdmin()]) ?>
<?= $form->field($model, 'first_name')->textInput() ?>
<?= $form->field($model, 'last_name')->textInput() ?>

<?= $form->field($model, 'email',['enableAjaxValidation'=>true]) ?>


<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

