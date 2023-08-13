<?php

namespace app\controllers;

use app\models\taskmodels\TaskAssignments;
use app\models\taskmodels\Tasks;
use app\models\usermodels\User;
use DateTime;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Authentication as authy;
use yii\web\ForbiddenHttpException;

Class TaskController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create'], // add all actions to take guest to login page
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                ],
            ]
        ];
    }

    public function actionIndex(){

        $assignments = TaskAssignments::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $this->render('/task/index',['assignments'=>$assignments]);
    }

    public function actionCreate(){
        if(!authy::canCreateTasks()){
            throw new ForbiddenHttpException("You are not authorised to access this page! Please let an admin know if this is a mistake");
        }

        $users = User::find()->all();
        $model = new Tasks;
        $assignment = new TaskAssignments();

        if(isset($_POST['Tasks'])){
            $model->title = $_POST['Tasks']['title'];
            $model->description = $_POST['Tasks']['description'];
            if(isset($_POST['Tasks']['task_due'])){
                $model->task_due = strtotime($_POST['Tasks']['task_due']);
            }else{
                $model->task_due = time();
            }
            $model->created_on = time();
            $model->created_by = Yii::$app->user->id;
            $model->last_updated_on = time();
            $model->status = Tasks::STATUS_ONGOING;
            $model->save();
//            die(var_dump($model->errors) . var_dump($model));

            if(isset($_POST['TaskAssignments'])) {
                if(!empty($_POST['TaskAssignments']['user_id']))
                    foreach($_POST['TaskAssignments']['user_id'] as $assignee){
                        $assignment = new TaskAssignments();
                        $assignment->task_id = $model->id;
                        $assignment->user_id = $assignee;
                        $assignment->assigned_on = time();
                        $assignment->save() && $model->assign($model,$assignment->user_id);
                    }
            }
        }

        return $this->render('/task/create',['model'=>$model,'users'=>$users,'assignment'=>$assignment]);
    }

    public function actionView($id){
        $taskModel = Tasks::find()->where(['id'=>$id])->one();
        $assignees = TaskAssignments::find()->where(['task_id'=>$id])->all();

        return $this->render('/task/view',['task'=>$taskModel,'assignedTo'=>$assignees]);
    }

    public function actionUpdate($taskId){
        $task = Tasks::find()->where(['id'=>$taskId])->one();
        $assignments = TaskAssignments::find()->where(['task_id'=>$taskId])->all();
//        die(var_dump($task));

        if($task->created_by != Yii::$app->user->id || !authy::isTaskAdmin()){
            throw new ForbiddenHttpException("You are not authorised to edit this task. Please contact an admin if you believe this is in error,");
        }

        $users = User::find()->all();
        $model = $task;
        $assignment = new TaskAssignments();

        if(isset($_POST['Tasks'])){
            $model->title = $_POST['Tasks']['title'];
            $model->description = $_POST['Tasks']['description'];
            $model->task_due = strtotime($_POST['Tasks']['task_due']);
            $model->created_on = time();
            $model->created_by = Yii::$app->user->id;
            $model->last_updated_on = time();
            $model->status = Tasks::STATUS_ONGOING;
            $model->save();
//            die(var_dump($model->errors) . var_dump($model));

            if(isset($_POST['TaskAssignments'])) {
                if(!empty($_POST['TaskAssignments']['user_id'])) {
                    // if  new assignee are posted, clear current assignees before setting new ones
                    foreach ($assignments as $current) {
                        $current->delete();
                    }

                    foreach ($_POST['TaskAssignments']['user_id'] as $assignee) {
                        $assignment = new TaskAssignments();
                        $assignment->task_id = $model->id;
                        $assignment->user_id = $assignee;
                        $assignment->assigned_on = time();
                        $assignment->save();
                        $assignment->save() && $model->assign($model,$assignment->user_id);
                    }
                }
            }
        }

        return $this->render('/task/update',[
            'model'=>$model,
            'users'=>$users,
            'assignment'=>$assignment,
            'assignments' => $assignments]);
    }
}