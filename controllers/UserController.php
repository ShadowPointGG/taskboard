<?php

namespace app\controllers;

use app\models\taskmodels\TaskAssignments;
use app\models\taskmodels\Tasks;
use app\models\taskmodels\TaskSearch;
use app\models\usermodels\User;
use Yii;
use yii\filters\AccessControl;
use yii\rbac\Permission;
use yii\web\Controller;
use app\models\PermissionManagement;
use app\models\Authentication as authy;
use yii\web\ForbiddenHttpException;

Class UserController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
//                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'update','delete','create','assign-roles','clear-roles'], // add all actions to take guest to login page
                        'allow' => true,
                        'roles' => ['@'],

                    ],
                    [
                        'actions' => ['verify-email'],
                        'allow' => true,
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

        $accessRights = Yii::$app->authManager->getRolesByUser($id);

        $renderOptions = [
            'user'=>$user,
            'tasks'=>$tasks,
            'searchModel'=>$searchModel,
            'dataProvider' => $dataProvider,
            'accessRights' => $accessRights];

        if(isset($_POST['User'])){
            $post = $_POST['User'];
            $changed = false;

            if(isset($post['username']) && $post['username'] != $user->username){
                $user->username = $post['username'];
                $changed = true;
            }
            if(isset($post['first_name']) && $user->first_name != $post['first_name']) {
                $user->first_name = $post['first_name'];
                $changed = true;
            }
            if(isset($post['last_name']) && $user->last_name != $post['last_name']) {
                $user->last_name = $post['last_name'];
                $changed = true;
            }
            if(isset($post['email']) && $user->email != $post['email']) {
                $user->email = $post['email'];
                $changed = true;
            }

            if((isset($post['newPassword']) && isset($post['oldPassword']) && isset($post['repeatPassword'])) && User::updateValidatePassword(Yii::$app->user->id,$post['oldPassword'])){
                if($post['newPassword'] != $post['repeatPassword'] || !User::updateValidatePassword(Yii::$app->user->id,$post['oldPassword'])){
                    Yii::$app->session->setFlash('error','Passwords do not match!');
                    return $this->render('index',['user'=>$user,'tasks'=>$tasks,'searchModel'=>$searchModel,'dataProvider' => $dataProvider]);

                }
                $user->setPassword($post['newPassword']);
                $changed = true;
            }
            if($changed){
                $user->save() && User::sendUpdateEmail($user);
                Yii::$app->session->addFlash('success','User Profile Updated Successfully');
            }
            return $this->render('index',$renderOptions);

        }

        return $this->render('index',$renderOptions);
    }

    public function actionAssignRoles($id){
        if(!authy::isUserAdmin()){
            throw new ForbiddenHttpException('You do not have permission to access this page!');
        }

        if(isset($_POST['roles'])){
            // first clear all user permissions
            $perms = PermissionManagement::find()->where(['user_id'=>$id])->all();
            foreach($perms as $perm){
                $perm->delete();
            }

            // loop through submitted permissions and add them
            foreach($_POST['roles'] as $roleName){
                if($roleName == "globalAdmin"){
                    $role = Yii::$app->authManager->getRole($roleName);
                    Yii::$app->authManager->assign($role,$id);
                    return $this->redirect(['user/index','id'=>$id]);
                }else{
                    $role = Yii::$app->authManager->getRole($roleName);
                    Yii::$app->authManager->assign($role,$id);
                }
                return $this->redirect(['user/index','id'=>$id]);
            }
        }
        return $this->redirect(['/user/index','id'=>$id]);
    }

    public function actionClearRoles($id){
        if(!authy::isUserAdmin()){
            throw new ForbiddenHttpException("You cannot access this page!");
        }

        $perms = PermissionManagement::find()->where(['user_id'=>$id])->all();
        foreach($perms as $perm){
            $perm->delete();
        }

        return $this->redirect(['/user/index','id'=>$id]);
    }

}