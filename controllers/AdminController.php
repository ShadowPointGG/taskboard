<?php

namespace app\controllers;

use app\models\Authentication as authy;
use app\models\taskmodels\TaskAssignments;
use app\models\taskmodels\Tasks;
use app\models\taskmodels\TaskSearch;
use app\models\usermodels\User;
use app\models\usermodels\UserSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use Yii;

Class AdminController extends Controller{

    public function actionIndex()
    {
        if(!authy::isGlobalAdmin()){
            throw new ForbiddenHttpException("You are not authorised to access this page! Please let an admin know if this is a mistake");
        }

        return $this->render('index');
    }

    public function actionTaskDashboard(){

        if(!authy::isTaskAdmin()){
            throw new ForbiddenHttpException("You are not authorised to access this page! Please let an admin know if this is a mistake");
        }

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('task-dashboard',
            [
                'dataProvider'=>$dataProvider,
                'searchModel' => $searchModel
            ]);
    }

    public function actionUserDashboard(){
        if(!authy::isUserAdmin()){
            throw new ForbiddenHttpException("You are not authorised to access this page! Please let an admin know if this is a mistake");
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user-dashboard',
            [
                'dataProvider'=>$dataProvider,
                'searchModel' => $searchModel
            ]);
    }

    public function actionDisableUser($id){
        if(!authy::isUserAdmin()){
            throw new ForbiddenHttpException("You are not authorised to access this page! Please let an admin know if this is a mistake");
        }

        if($id == Yii::$app->user->id){
            throw new ForbiddenHttpException("You cannot delete your own user account!");
        }

        $user = User::find()->where(['id'=>$id])->one();
        $user->status = User::STATUS_DELETED;
        $user->save();

        $assignment = TaskAssignments::find()->where(['user_id'=>$id])->all();
        foreach($assignment as $assigned){
            $assigned->delete();
        }

        return $this->redirect('/admin/users');
    }
    public function actionEnableUser($id){
        if(!authy::isUserAdmin()){
            throw new ForbiddenHttpException("You are not authorised to access this page! Please let an admin know if this is a mistake");
        }

        $user = User::find()->where(['id'=>$id])->one();
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        return $this->redirect('/admin/users');
    }

}