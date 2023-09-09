<?php

use yii\helpers\Url;

$link = Url::to(['/task/view', 'id' => $task->id],'http');
?>

<?=APPLICATION_NAME?>
Hi <?=$user->first_name?>,

You have been assigned a task on <?=COMPANY_NAME?>'s TaskBoard.

Please Log in to view this task:
Task Name: <?=$task->title?>
Task Details: <?=$task->description?>
Task Due On: <?= date('m/d/Y',$task->task_due)?>

    <!--INSERT VERIFICATION LINK HERE-->
<?= $link ?>

<br>
Please note dates are in the American format of month/day/year (e.g. <?=date('m/d/Y',time())?>)