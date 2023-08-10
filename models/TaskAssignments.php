<?php

namespace app\models;

use yii\db\ActiveRecord;

Class TaskAssignments extends ActiveRecord {

    public static function tableName()
    {
        return "{{task_addignment}}";
    }

}