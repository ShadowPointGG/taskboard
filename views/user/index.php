<?php

use kartik\tabs\TabsX;

/**
 * Define the Blocks for the Tabs
 */

$this->beginBlock('default');
echo $this->render('/user/pages/default',['user' => $user]);
$this->endBlock();

$this->beginBlock('edit');
include("pages/edit.php");
$this->endBlock();

$this->beginBlock('security');
include("pages/security.php");
$this->endBlock();

$this->beginBlock('tasks');
include("pages/tasks.php");
$this->endBlock();



$items = [
    [
        'label'=>'<i class="fas fa-home"></i> Dashboard',
        'content'=>$this->blocks['default'],
        'active'=>true
    ],
    [
        'label'=>'<i class="fas fa-user"></i> Update Profile',
        'content'=>$this->blocks['edit'],
    ],
    [
        'label'=>'<i class="fas fa-list-alt"></i> My Tasks',
        'content' => $this->blocks['tasks'],
    ],
    [
        'label'=>'<i class="fas fa-key"></i> Login and Security',
        'content' => $this->blocks['security']
    ],
];

echo TabsX::widget([
    'enableStickyTabs' => true,
    'bsVersion' => "5.x",
    'encodeLabels' => false,
    'items' => $items,
//    'position' => TabsX::POS_LEFT,
]);