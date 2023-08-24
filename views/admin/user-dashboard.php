<?php

use app\models\usermodels\User;
use kartik\bs5dropdown\ButtonDropdown;
use kartik\bs5dropdown\Dropdown;
use kartik\daterange\DateRangePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Authentication as authy;

$columns = [
    'username',
    'email',
    'first_name',
    'last_name',
    [
        'label'=>'status',
        'attribute' => 'status',
        'value'=> function($data) {
            switch ($data->status) {
                case User::STATUS_ACTIVE:
                    return "Active";
                case User::STATUS_INACTIVE:
                    return "Inactive";
                case User::STATUS_DELETED:
                    return "Disabled";
            }
        },
        'filter'=>array(User::STATUS_ACTIVE=>"Active",User::STATUS_INACTIVE=>"Inactive",User::STATUS_DELETED=>"Disabled"),
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Actions',
        'headerOptions' => ['style' => 'color:#337ab7'],
        'template' => '{view}     {update}     {status}     {rights}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="fa fa-user"></span>',
                    Url::to(['/task/view', 'id' => $model->id]),['title'=>'View User']);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="fa fa-pen"></span>',
                    Url::to(['/user', 'id' => $model->id,'#' => 'w4-tab1']),['title'=>'Edit User']);
            },
            'status' => function ($url, $model) {
            if($model->id != Yii::$app->user->id) {
                if ($model->status == User::STATUS_ACTIVE) {
                    return Html::a('<span class="fa fa-ban"></span>',
                        Url::to(['/admin/disable-user', 'id' => $model->id]),['title'=>'Disable User']);
                } else if ($model->status == User::STATUS_DELETED) {
                    return Html::a('<i class="fa fa-check"></i>',
                        Url::to(['/admin/enable-user', 'id' => $model->id]),['title'=>'Enable User']);
                }
            }else return "";
            },
            'rights' => function($url, $model) {
                if ($model->id != Yii::$app->user->id) {
                    return Html::a('<span class="fa fa-lock"></span>',
                        Url::to(['/user', 'id' => $model->id, '#' => 'w4-tab3']), ['title' => 'Edit Permissions']);
                }
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
    <?= authy::canCreateUser() ? Html::a('Invite a User', ['/site/invite'], ['class'=>'btn btn-primary']) : null?></div>
    <div class="col-md-6"></div>
    <div class="col-md-2">
    <?= ButtonDropdown::widget([
        'label' => 'Sort By',
        'dropdown' => [
            'items' => [
                ['label' => 'Username Asc +', 'url' => ['/admin/user-dashboard','sort'=>'username']],
                ['label' => 'Username Desc -', 'url' => ['/admin/user-dashboard','sort'=>'-username']],

                ['label' => 'Email Asc +', 'url' => ['/admin/user-dashboard','sort'=>'email']],
                ['label' => 'Email Desc -', 'url' => ['/admin/user-dashboard','sort'=>'-email']],

                ['label' => 'First Name Asc +', 'url' => ['/admin/user-dashboard','sort'=>'first_name']],
                ['label' => 'First Name Desc -', 'url' => ['/admin/user-dashboard','sort'=>'-first_name']],

                ['label' => 'Last Name Asc +', 'url' => ['/admin/user-dashboard','sort'=>'last_name']],
                ['label' => 'Last Name Desc -', 'url' => ['/admin/user-dashboard','sort'=>'-last_name']],

            ],
        ],
        'buttonOptions' => ['class' => 'btn-outline-secondary','style' => 'align: right']
    ]);?></div>
</div>
<br>


<?= $taskView ?>