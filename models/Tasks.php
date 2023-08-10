<?php

namespace app\models;

use yii\db\ActiveRecord;

Class Tasks extends ActiveRecord {

    public static function tableName()
    {
        return "{{tasks}}";
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Task Name: ',
        ];
    }

}