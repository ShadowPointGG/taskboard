<?php

namespace app\models;

use yii\base\Model;

Class Authentication extends Model{

    public static function tableName(){
        return '{{%auth_assignment}}';
    }

}