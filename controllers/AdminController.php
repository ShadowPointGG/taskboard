<?php

namespace app\controllers;

use app\models\Authentication;
use app\models\Authentication as authy;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

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
        return $this->render('task-dashboard');
    }

}