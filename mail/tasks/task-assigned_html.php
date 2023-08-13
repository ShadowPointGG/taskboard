<?php

use yii\helpers\Url;

$link = Url::to(['/site/verify-email', 'token' => $user->verification_token],'http');
?>

    <h1><?=APPLICATION_NAME?></h1>

    <h2>Hi <?=$user->first_name?>,</h2>

    <p>You have been assigned a task on <?=COMPANY_NAME?>'s TaskBoard.</p>

    <p>Please Log in to view <a href="<?=$link?>">this task</a>:</p>

    <p>Task Name: <?=$task->title?></p>
    <p>Task Details: <?=$task->description?></p>
    <p>Task Due On: <?= date('m/d/Y',$task->task_due)?></p>

    <!--INSERT VERIFICATION LINK HERE-->
<?= $link ?>

<br><br>
<sub>Please note dates are in the American format of month/day/year (e.g. <?=date('m/d/Y',time())?>)</sub>