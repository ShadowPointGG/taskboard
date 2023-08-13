<?php

namespace app\models\taskmodels;

use yii\db\ActiveRecord;

Class TaskAssignments extends ActiveRecord {

    public static function tableName()
    {
        return "{{task_assignment}}";
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User to assign to!'
        ];
    }

}