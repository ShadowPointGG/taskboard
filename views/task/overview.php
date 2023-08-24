<?php

use app\models\taskmodels\Tasks;
use app\models\usermodels\User;
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Authentication as authy;

$totalTasks = count($tasks);
$totalOngoing = 0;
$totalDue = 0;
$totalComplete = 0;
$totalOverdue = 0;

foreach($tasks as $task){
    if($task['status'] == Tasks::STATUS_ONGOING){
        $totalOngoing += 1;
    }else if($task['status'] == Tasks::STATUS_DUE){
        $totalDue += 1;
    }else if($task['status'] == Tasks::STATUS_OVERDUE){
        $totalOverdue += 1;
    }else if($task['status'] == Tasks::STATUS_COMPLETE){
        $totalComplete += 1;
    }
}



$taskChart = ChartJs::widget([
    'type' => 'doughnut',

    'data' => [
        'labels' => ["Complete","Ongoing", "Due", "Overdue"],
        'datasets' => [
            [
                'label' => "My First dataset",
                'backgroundColor' => [
                    "rgba(0,255,0,0.5)",
                    "rgba(255,255,0,0.5)",
                    "rgba(255,165,0,0.5)",
                    "rgba(255,0,0,0.5)",
                ],
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "rgba(255,0,0,1)",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [$totalComplete, $totalOngoing, $totalDue, $totalOverdue]
            ],
        ]
    ]
]);

?>

<h1>Task Overview for <?=$user->first_name?> (<?=$user->username?>),</h1>
<br>
<?php
if(authy::isUserAdmin())
    switch ($user->status) {
        case User::STATUS_ACTIVE:
            echo "User Status: Active <br>";
            break;
        case User::STATUS_INACTIVE:
            echo "User Status: Inactive <br>";
            break;
        case User::STATUS_DELETED:
            echo "User Status: Disabled <br>";
            break;
    }
?>
<br><br>
<div class="row">
    <div class="col-md-3 info-box" style="border: 5px inset #1a1a1a; border-radius: 5px">
        <h2>Task Summary:</h2>
        <br>
        <h3>Total: <?=$totalTasks?></h3><br>
        <h3>Ongoing: <?=$totalOngoing?></h3><br>
        <h3>Due: <?=$totalDue?></h3><br>
        <h3>OverDue: <?=$totalOverdue?></h3><br>
        <h3>Complete: <?=$totalComplete?></h3><br>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-8 info-box" style="border: 5px inset #1a1a1a; border-radius: 5px">
        <?=$taskChart?>
    </div>
</div>

