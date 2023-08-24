<?php

namespace app\controllers;

use app\models\taskmodels\TaskAssignments;
use app\models\taskmodels\TaskComments;
use app\models\taskmodels\Tasks;
use app\models\taskmodels\TaskSearch;
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
                        'actions' => ['index',
                            'view',
                            'update',
                            'delete',
                            'create',
                            'change-status',
                            'overview'], // add all actions to take guest to login page
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                ],
            ]
        ];
    }

    public function actionIndex($id){

        $user = User::find()->where(['id'=>$id])->one();
        $userAssignments = TaskAssignments::find()->where(['user_id'=>$id])->all();
        $taskIds = [];
        foreach($userAssignments as $assignment){
            $taskIds[] = $assignment->task_id;
        }
        $tasks = Tasks::findAll($taskIds);

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->searchByUser(Yii::$app->request->queryParams, $tasks);

        return $this->render('/task/index',['user'=>$user,'searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'tasks'=>$tasks]);
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

        $comments = TaskComments::find()->where(['task_id'=>$id])->orderBy(['id'=>SORT_DESC])->all();
        $newComment = new TaskComments();

        if(isset($_POST['TaskComments'])){
            $newComment->task_id = $id;
            $newComment->comment = $_POST['TaskComments']['comment'];
            $newComment->created_by = Yii::$app->user->id;
            $newComment->created_on = time();
            $newComment->save();
            return $this->redirect(['/task/view','id'=>$id]);
        }

        return $this->render('/task/view',[
            'task'=>$taskModel,
            'assignedTo'=>$assignees,
            'comments'=>$comments,
            'commentModel' => $newComment]);
    }
    public function actionDelete($id){
        $taskModel = Tasks::find()->where(['id'=>$id])->one();
        $taskModel->delete();

        $taskAssignments = Tasks::find()->where(['task_id' => $id])->all();
        foreach($taskAssignments as $assignment){
            $assignment->delete();
        }

        return $this->redirect(['/admin/task-dashboard']);
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

    public function actionChangeStatus($task, $status){
        $taskModel = Tasks::find()->where(['id'=>$task])->one();

        if($taskModel->created_by != Yii::$app->user->id || !authy::isTaskAdmin()){
            throw new ForbiddenHttpException("You are not authorised to edit this task. Please contact an admin if you believe this is in error,");
        }

        $taskModel->status = $status;
        $taskModel->save();

        return $this->redirect(['/task/view','id'=>$task]);
    }

    public function actionOverview($id){
        $user = User::find()->where(['id'=>$id])->one();
        $userAssignments = TaskAssignments::find()->where(['user_id'=>$id])->all();
        $taskIds = [];
        foreach($userAssignments as $assignment){
            $taskIds[] = $assignment->task_id;
        }
        $tasks = Tasks::findAll($taskIds);

        return $this->render('/task/overview',['tasks'=>$tasks,'user'=>$user]);
    }

    public static function updateAllStatus(): void
    {
        $tasks = Tasks::find()->all();
        foreach($tasks as $task){
            switch($task->task_due):
                case $task->task_due>time():
                    $task->status = Tasks::STATUS_OVERDUE;
                    break;
                case ($task->task_due - 259200) < time() && time() < $task->task_due:
                    $task->status == Tasks::STATUS_DUE;
                    break;
                case ($task->task_due - 259200) < time():
                    $task->status == Tasks::STATUS_ONGOING;
                    break;
            endswitch;
        }
    }
}