<?php

namespace app\models\taskmodels;

use app\models\usermodels\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

Class Tasks extends ActiveRecord {

    const STATUS_ONGOING = 9;
    const STATUS_COMPLETE = 10;
    const STATUS_OVERDUE = 11;
    const STATUS_DUE = 12;
    public static function tableName()
    {
        return "{{tasks}}";
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Task Name: ',
            'description' => 'Task Description: ',
            'task_due' => 'Task Due On: '
        ];
    }

    public function assign($task,$assignee){
        $user = User::find()->where(['id'=>$assignee])->one();

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'tasks/task-assigned_html', 'text' => 'tasks/task-assigned_txt'],
                ['user' => $user, 'task'=>$task]
            )
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo($user->email)
            ->setSubject('Task Assigned on '.COMPANY_NAME)
            ->send();
    }


}