<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class PermissionManagement extends ActiveRecord{
//
////    main roles
//    public $globalAdmin;
//    public $taskAdmin;
//    public $userAdmin;
//    public $siteAdmin;
//
////    child roles
//    public $siteConfig;
//    public $taskCreate;
//    public $taskUpdate;
//    public $taskDelete;
//    public $userDelete;
//    public $userUpdate;
//    public $userCreate;

    public static function tableName()
    {
        return "{{auth_assignment}}";
    }


    public static function getRolesAndChildren(): array
    {
        $parents = Yii::$app->authManager->getRoles();
        $parentRole = [];
        $roles = [];
        foreach($parents as $parent){
            $parentRole[] = $parent->name;

            $children = Yii::$app->authManager->getChildren($parent->name);
            foreach($children as $child){
                $parentRole[$parent->name][] = $child->name;
            }
        }

        foreach($parentRole as $role){
            if(gettype($role) == "array"){
                $roles[array_search($role,$parentRole)] = $role;
            }
        }
        return $roles;
    }
}