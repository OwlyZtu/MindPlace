<?php

namespace app\models\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $created_at;
    public $specialization;
    public $city;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'created_at', 'specialization', 'city'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()->where(['role' => 'specialist']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'specialization', $this->specialization]);

        return $dataProvider;
    }
}