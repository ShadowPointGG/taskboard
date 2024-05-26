<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \app\models\usermodels\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
                'id' => 'login-form',
//                'fieldConfig' => [
//                    'template' => "{label}\n{input}\n{error}",
////                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
////                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
////                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
//                ],
            ]); ?>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-12 col-xl-10">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12 d-none d-lg-flex">
<!--                        url(&quot;assets/img/Shadow_Point%20(1).png&quot;) center / contain;"></div>-->
                        <div class="flex-grow-1 bg-login-image" style="background: url(<?= Url::to('@web/images/Shadow_Point_BG.png')?>) center / contain">
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Welcome Back!</h4>
                            </div>
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>

                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                            ]) ?>

                            <div class="form-group">
                                <div>
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>