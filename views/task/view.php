<?php
use app\models\usermodels\User;


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

<br><hr>

<h2>Details: </h2>

<br>
<i id="task-description"><?=$task->description?></i>

<br><br>
