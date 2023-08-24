<?php

use kartik\select2\Select2;
use yii\bootstrap5\Modal;
use yii\helpers\Html;

$currentRights = "Current Roles: ";
if(!empty($accessRights)) {
    foreach ($accessRights as $rights) {
        $currentRights .= $rights->name . ", ";
    }
    $currentRights = rtrim($currentRights,", ");
}else{
    $currentRights = "No Roles Assigned";
}

$items = [
    "Global Admin" => [
        "globalAdmin" => 'Global Administrator',
        "administrator" => 'Administrator',
        "siteAdmin" => 'Site Administrator'
    ],
    "Administrator" => [
        "taskAdmin" => 'Task Administrator',
        "userAdmin" => 'User Administrator'
    ],
    "Site Admins" => [
        "siteConfig" => "Site Configurator"
    ],
    "Task Administration" => [
        "taskAdmin" => "Task Administrator",
        "taskCreate" => "Create Tasks",
        "taskUpdate" => "Update Tasks",
        "taskDelete" => "Delete Tasks"
    ],
    "User Administration" => [
        "userAdmin" => "User Administrator",
        "userCreate" => "Create Users",
        "userUpdate" => "Update Users",
        "userDelete" => "Delete Users"
    ]
];

?>
<?=$currentRights?>
<hr>
<?php
Modal::begin([
    'title' => '<h2>Select Roles</h2>',
    'toggleButton' => ['label' => 'Assign Roles'],
]);
echo Html::beginForm(
        ['/user/assign-roles','id'=>$model->id],
        'POST');

echo Select2::widget([
    'name' => 'roles',
    'data' => $items,
    'options' => [
        'placeholder' => 'Select Roles ...',
        'multiple' => true
    ],
]);
echo "<hr>";
echo Html::submitButton('Assign Roles', ['class' => 'btn btn-success']);

Modal::end();

