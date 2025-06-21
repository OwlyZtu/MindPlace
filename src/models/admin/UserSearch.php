<?php
namespace app\models\admin;

use app\models\SpecialistApplication;
use yii\data\ActiveDataProvider;

class UserSearch extends SpecialistApplication
{
    public $name;
    public $specialization;
    public $city;

    public function rules()
    {
        return [
            [['id', 'user_id', 'admin_id'], 'integer'],
            [['status'], 'string'],
            [['comment', 'name', 'specialization', 'city', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = SpecialistApplication::find()->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => [
                    'id',
                    'comment',
                    'status',
                    'created_at',
                    'updated_at',
                    'name' => [
                        'asc' => ['user.name' => SORT_ASC],
                        'desc' => ['user.name' => SORT_DESC],
                    ],
                    'specialization' => [
                        'asc' => ['user.specialization' => SORT_ASC],
                        'desc' => ['user.specialization' => SORT_DESC],
                    ],
                    'city' => [
                        'asc' => ['user.city' => SORT_ASC],
                        'desc' => ['user.city' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'specialist_application.id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->name])
              ->andFilterWhere(['like', 'user.specialization', $this->specialization])
              ->andFilterWhere(['like', 'user.city', $this->city])
              ->andFilterWhere(['like', 'specialist_application.comment', $this->comment]);

        return $dataProvider;
    }
}
