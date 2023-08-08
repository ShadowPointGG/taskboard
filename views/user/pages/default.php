<?php

use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\helpers\Url;


$taskChart = ChartJs::widget([
    'type' => 'doughnut',

    'data' => [
        'labels' => ["Ongoing", "Due", "Overdue"],
        'datasets' => [
            [
                'label' => "My First dataset",
                'backgroundColor' => [
                        "rgba(0,255,0,0.5)",
                        "rgba(255,255,0,0.5)",
                        "rgba(255,0,0,0.5)",
                    ],
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "rgba(255,0,0,1)",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [18, 6, 10]
            ],
        ]
    ]
]);

?>

<h1>Welcome <?=strtoupper($user->username)?>,</h1>
<br>
<h3>Here is your dashboard.</h3>
<br><br>
<div class="row">
    <div class="col-md-3 info-box" style="border: 5px inset #1a1a1a; border-radius: 5px">
        <h2>Task Summary:</h2>
        <br>
        <h3>Total: 34</h3><br>
        <h3>Ongoing: 18</h3><br>
        <h3>Due: 6</h3><br>
        <h3>OverDue: 10</h3><br>
        <?php
       echo Html::a('Go To Tasks', ['/site/index'], ['class'=>'btn btn-primary'])
        ?>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-8 info-box" style="border: 5px inset #1a1a1a; border-radius: 5px">
        <?=$taskChart?>
    </div>
</div>