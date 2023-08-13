<?php

namespace app\models\taskmodels;

use yii\db\ActiveRecord;

Class TaskCategories extends ActiveRecord {

    public static function tableName()
    {
        return "{{task_categories}}";
    }

}