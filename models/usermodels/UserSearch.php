<?php

namespace app\models\usermodels;

use yii\data\ActiveDataProvider;

class UserSearch extends User{

    public function rules()
    {
        return [
            [['username','first_name','last_name','email'],'string'],
            [['id','status'],'integer'],
            [['username','first_name','last_name','email','id','status'],'safe']
        ];
    }

    public function search($params){
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'username',
                    'first_name',
                    'last_name',
                    'status',
                    'email',
                ]
            ]
        ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }

        $query->andFilterWhere(['like','username',$this->username]);
        $query->andFilterWhere(['like','email',$this->email]);
        $query->andFilterWhere(['like','first_name',$this->first_name]);
        $query->andFilterWhere(['like','last_name',$this->last_name]);
        $query->andFilterWhere(['status'=>$this->status]);

        return $dataProvider;
    }

}