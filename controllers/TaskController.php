<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

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

    public function actionIndex($id){
        
    }
}