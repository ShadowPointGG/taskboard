<?php

namespace app\models\taskmodels;

use kartik\daterange\DateRangeBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearch extends Tasks
{

    public $created_at_range;
    public function rules()
    {
        // only fields in rules() are searchable
        return [
            [['title','description'], 'string'],
            [['status','created_on'], 'integer'],
            [['created_at_range'], 'safe'], // add a rule to collect the values
            [['title', 'created_on', 'status', 'description','start_date','end_date'], 'safe'],
        ];
    }

    public function search($params){
        $query = Tasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'title',
                    'description',
                    'status',
                    'created_by',
                ]
            ]
        ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }



        $query->andFilterWhere(['like','title',$this->title]);
        $query->andFilterWhere(['like','description',$this->description]);
        $query->andFilterWhere(['status'=>$this->status]);
        $query->andFilterWhere(['created_by'=>$this->created_by]);

//        $dataProvider->getTotalCount() ;

        if(!empty($this->created_at_range) && strpos($this->created_at_range, '-') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->created_at_range);
            $query->andFilterWhere(['between', 'task_due', strtotime($start_date), strtotime($end_date)]);
        }

        return $dataProvider;
    }

}