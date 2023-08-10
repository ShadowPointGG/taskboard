<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\User;

Class UserController extends Controller{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
//                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'update','delete','create'], // add all actions to take guest to login page
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
        $user = User::findOne(['id'=>$id]);

        return $this->render('index',['user'=>$user]);
    }


}