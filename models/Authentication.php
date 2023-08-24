<?php

namespace app\models;

use app\models\usermodels\User;
use yii\base\Model;
use Yii;

Class Authentication extends Model{

    /**
     * Various Admin Checks
     */
    public static function isGlobalAdmin(): bool
    {
        return Yii::$app->user->can("globalAdmin");
    }

    public static function isSiteAdmin(): bool
    {
        return Yii::$app->user->can("siteAdmin");
    }

    public static function isAdmin(): bool
    {
        return Yii::$app->user->can("administrator") || Yii::$app->user->can("globalAdmin") || Yii::$app->user->can("siteAdmin");
    }

    /**
     * User should only be able to edit their own profiles, or an Admin can edit them
     */
    public static function canEditUser($id): bool
    {
        return Yii::$app->user->id == $id || Yii::$app->user->can("userUpdate");
    }

    public static function canCreateUser(): bool
    {
        return Yii::$app->user->can("userCreate");
    }

    public static function canDeleteUser(): bool
    {
        return Yii::$app->user->can("userDelete");
    }

    public static function canUpdateUsers(): bool
    {
        return Yii::$app->user->can('userUpdate');
    }


    public static function isUserAdmin(): bool
    {
        return Yii::$app->user->can("userAdmin");

    }

    /**
     * Task Auths
     * @return bool
     */

    public static function isTaskAdmin(): bool
    {
        return Yii::$app->user->can('taskAdmin');
    }

    public static function canCreateTasks(): bool
    {
        return Yii::$app->user->can('taskCreate');
    }

    public static function canDeleteTasks(): bool
    {
        return Yii::$app->user->can('taskDelete');
    }
    public static function canUpdateTasks(): bool
    {
        return Yii::$app->user->can('taskUpdate');
    }


    // user permission check

    public static function checkPerm($id,$perm): bool
    {
        return Yii::$app->authManager->checkAccess($id,$perm);
    }

}