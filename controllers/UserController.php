<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\User;

Class UserController extends Controller{

    public function actionIndex($id){
        $user = User::findOne(['id'=>$id]);

        return $this->render('index',['user'=>$user]);
    }
}