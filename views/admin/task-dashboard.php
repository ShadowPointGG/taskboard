<?php

use app\models\taskmodels\Tasks;
use app\models\usermodels\User;
use kartik\bs5dropdown\ButtonDropdown;
use kartik\bs5dropdown\Dropdown;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

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

<div class="row">
    <div class="col-md-4">
    <?= Html::a('Create a task!', ['/task/create'], ['class'=>'btn btn-primary']) ?></div>
    <div class="col-md-6"></div>
    <div class="col-md-2">
    <?= ButtonDropdown::widget([
        'label' => 'Sort By',
        'dropdown' => [
            'items' => [
                ['label' => 'Title Asc +', 'url' => ['/admin/task-dashboard','sort'=>'title']],
                ['label' => 'Title Desc -', 'url' => ['/admin/task-dashboard','sort'=>'-title']],

                ['label' => 'Description Asc +', 'url' => ['/admin/task-dashboard','sort'=>'description']],
                ['label' => 'Description Desc -', 'url' => ['/admin/task-dashboard','sort'=>'-description']],

                ['label' => 'Due Date Asc +', 'url' => ['/admin/task-dashboard','sort'=>'task_due']],
                ['label' => 'Due Date Desc -', 'url' => ['/admin/task-dashboard','sort'=>'-task_due']],

            ],
        ],
        'buttonOptions' => ['class' => 'btn-outline-secondary','style' => 'align: right']
    ]);?></div>
</div>
<br>


<?= $taskView ?>