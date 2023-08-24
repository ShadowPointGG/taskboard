<?php

use app\models\taskmodels\Tasks;
use app\models\usermodels\User;
use dosamigos\chartjs\ChartJs;
use kartik\bs5dropdown\ButtonDropdown;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
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

$datePicker = DateRangePicker::widget([
    'name'=>'date_range_2',
    'presetDropdown'=>true,
    'convertFormat'=>true,
    'includeMonthsFilter'=>true,
    'pluginOptions' => ['locale' => ['format' => 'd-M-y']],
    'options' => ['placeholder' => 'Select range...']
]);

$columns = [
    'title',
    'description',
    [
        'label'=>'Created By',
        'attribute' => 'created_by',
        'value'=> function($data){
            return User::getUsername($data);
        },
        'filter'=>Html::activeDropDownList($searchModel, 'created_by', ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),['class'=>'form-control','prompt' => 'Select User']),
    ],
    [
        'label' => 'Task Due',
//        'filterType' => GridView::FILTER_DATE_RANGE,
        'value' => function($data){
            return date('d M Y',$data->task_due);
        },
        'enableSorting' => true,
        'filter' => DateRangePicker::widget([
            'model' => $searchModel,
            'attribute' => 'created_at_range',
            'pluginOptions' => [
                'format' => 'd-m-Y',
                'autoUpdateInput' => false
            ]
        ])

    ],
    [
        'header'=>'Task Status',
        'attribute' => 'status',
        'label' => 'status',
        'value' => function($data){
            switch ($data->status){
                case Tasks::STATUS_ONGOING:
                    return "Ongoing";
                case Tasks::STATUS_DUE:
                    return "DUE";
                case Tasks::STATUS_OVERDUE:
                    return "OVERDUE";
                case Tasks::STATUS_COMPLETE:
                    return "Complete";
            }
        },
        'filter'=>array(Tasks::STATUS_COMPLETE=>"Complete",Tasks::STATUS_OVERDUE=>"Overdue",Tasks::STATUS_ONGOING=>"Ongoing",Tasks::STATUS_DUE=>"Due",),
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Actions',
        'headerOptions' => ['style' => 'color:#337ab7'],
        'template' => '{view}     {update}     {delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-eye"></span>',
                    Url::to(['/task/view', 'id' => $model->id]));
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="fa fa-pen"></span>',
                    Url::to(['/task/update', 'taskId' => $model->id]));
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="fa fa-trash"></span>',
                    Url::to(['/task/delete', 'id' => $model->id]));
            }
        ]

    ],

];

$taskView = GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'responsive'=>true,
    'hover'=>true,
    'columns' => $columns,
])
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
<div class="row" style="border: 5px inset #1a1a1a; border-radius: 5px; padding: 30px">
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
<br><br>
<div class="row" style="border: 5px inset #1a1a1a; border-radius: 5px; padding: 30px">
    <h2>Your Assigned Tasks:</h2>
    <br><br>
<?=$taskView?>
</div>

