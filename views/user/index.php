<?php

use app\models\PermissionManagement;
use kartik\tabs\TabsX;
use app\models\Authentication as authy;

/**
 * Define the Blocks for the Tabs
 */

$this->beginBlock('default');
echo $this->render('/user/pages/default',
    ['user' => $user,
        'tasks'=>$tasks,
        'searchModel'=>$searchModel,
        'dataProvider'=>$dataProvider
    ]);
$this->endBlock();

$this->beginBlock('edit');
echo $this->render("/user/pages/edit",
    ['model'=>$user,
        'accessRights' => $accessRights,
        'permissions' => PermissionManagement::getRolesAndChildren()]);
$this->endBlock();

$this->beginBlock('security');
echo $this->render("/user/pages/security",
    ['model'=>$user]);
$this->endBlock();



$items = [
    [
        'label'=>'<i class="fas fa-list-alt"></i> My Tasks',
        'content'=>$this->blocks['default'],
        'active'=>true
    ],
    [
        'label'=>'<i class="fas fa-user"></i> Update Profile',
        'content'=>$this->blocks['edit'],
    ],
    [
        'label'=>'<i class="fas fa-key"></i> Login and Security',
        'content' => $this->blocks['security'],
        'visible' => Yii::$app->user->id == $user->id
    ],

];

echo TabsX::widget([
    'enableStickyTabs' => true,
    'bsVersion' => "5.x",
    'encodeLabels' => false,
    'items' => $items,
//    'position' => TabsX::POS_LEFT,
]);