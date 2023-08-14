<?php

namespace app\controllers;

use app\models\Authentication;
use app\models\Authentication as authy;
use app\models\taskmodels\Tasks;
use app\models\taskmodels\TaskSearch;
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

        //get a model of all tasks on system. defaults to active. complete will be hidden

        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('task-dashboard',
            [
                'dataProvider'=>$dataProvider,
                'searchModel' => $searchModel
            ]);
    }

}