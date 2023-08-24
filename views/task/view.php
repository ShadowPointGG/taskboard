<?php

use app\models\taskmodels\Tasks;
use app\models\usermodels\User;
use kartik\bs5dropdown\ButtonDropdown;
use app\models\Authentication as authy;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$dateDiff = ceil((round($task->task_due-time()))/86400);

if($dateDiff < 0){
    $remainder = "<h4 style='color: darkred'>(".$dateDiff." days overdue)</h4>";
}else{
    $remainder = "<h4>(".$dateDiff." days remaining)</h4>";
}
?>

<h1><?=$task->title?></h1><br>
<h4>Due on:  <?= date('m/d/Y',$task->task_due)?></h4> <?=$remainder?>
<br>

<?php
$currentAssign = "";
if(!empty($assignedTo)) {
    $currentAssign = "This task is currently assigned to: ";
    foreach ($assignedTo as $assignee) {
        $currentAssign .= User::getUsername($assignee['user_id']) . ', ';
    }
    $currentAssign = substr($currentAssign,0,-2);
}else $currentAssign = "This task is not currently assigned to anyone.";
echo "<sub><i>".$currentAssign."</i></sub>";
?>
<hr>
<?php
switch ($task->status){
    case Tasks::STATUS_ONGOING:
        echo "Current Status: Ongoing";
        break;
    case Tasks::STATUS_DUE:
        echo "Current Status: DUE";
        break;
    case Tasks::STATUS_OVERDUE:
        echo "Current Status: OVERDUE";
        break;
    case Tasks::STATUS_COMPLETE:
        echo "Current Status: Complete";
        break;
}
?>
<?php if(authy::isTaskAdmin()) echo "   " . ButtonDropdown::widget([
    'label' => 'Change Status',
    'dropdown' => [
        'items' => [
            ['label' => 'Ongoing', 'url' => ['/task/change-status','task'=>$task->id,'status'=>Tasks::STATUS_ONGOING]],
            ['label' => 'Complete', 'url' => ['/task/change-status','task'=>$task->id,'status'=>Tasks::STATUS_COMPLETE]],

        ],
    ],
    'buttonOptions' => ['class' => 'btn-outline-secondary']
]);?>

<br><hr>

<h2>Details: </h2>

<br>
<i id="task-description"><?=$task->description?></i>

<br><br>
<div class="row">

    <div class="col-md-5" style="padding: 15px">
        <h3>Task Comments: <i>(most recent first)</i> </h3>
        <br>
        <?php
            if(count($comments) == 0){
                echo "<i>No comments have been posted!<br></i>";
                Modal::begin([
//                    'header' => '<h2>Hello world</h2>',
                    'toggleButton' => ['label' => 'Post the first Comment'],
                ]);
                include("_add_comment.php");
                Modal::end();
            }else{
                foreach($comments as $comment){
                ?>
        <div class="row" style="border: 1px inset #e3e3e3; border-radius: 15px; padding: 15px">
            <i>Posted by <?=User::getUsername($comment->created_by)?> - <?=date('F j, Y, g:i a',$comment->created_on)?></i>
            <i><?=$comment->comment?></i>
        </div>
                    <br>
        <?php
                }
                Modal::begin([
//                    'header' => '<h2>Hello world</h2>',
                    'toggleButton' => ['label' => 'Post a Comment'],
                ]);
                include("_add_comment.php");
                Modal::end();
            }
        ?>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-5" style="padding: 15px">
        <h3>Task Files: </h3>
    </div>

</div>