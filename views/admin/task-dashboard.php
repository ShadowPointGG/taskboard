<?php

use app\models\taskmodels\Tasks;
use app\models\usermodels\User;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\Html;

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
        }
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
        }
    ]

];

$taskView = GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'responsive'=>true,
    'hover'=>true,
    'columns' => $columns,
])
?>

<div class="row">
    <div class="col-md-4">
        <?= Html::a('Create a task!', ['/task/create'], ['class'=>'btn btn-primary']) ?>
    </div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
    </div>
</div>
<br>


<?= $taskView ?>