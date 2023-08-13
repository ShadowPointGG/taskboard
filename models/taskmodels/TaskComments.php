<?php

namespace app\models\taskmodels;

use yii\db\ActiveRecord;

Class TaskComments extends ActiveRecord {

    public static function tableName()
    {
        return "{{task_comments}}";
    }

}