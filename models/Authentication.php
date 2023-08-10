<?php

namespace app\models;

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

}