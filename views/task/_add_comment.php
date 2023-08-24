<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
   <?php $form = ActiveForm::begin(['options'=> [
    'id'=> 'comment-form'
]]);
?>
    <div class="modal-body">
        <?php echo $form->field($commentModel, 'comment')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="modal-footer">
        <?php echo Html::submitButton('Submit Comment', ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
<?php ActiveForm::end();