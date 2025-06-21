<?php
namespace app\models\admin;

use app\models\Article;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    public $name;
    public $specialization;
    public $city;

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['title', 'content', 'created_at', 'updated_at', 'name', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Article::find()->joinWith(['doctor']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => [
                    'id',
                    'title',
                    'user.name',
                    'created_at',
                    'updated_at',
                    'name' => [
                        'asc' => ['user.name' => SORT_ASC],
                        'desc' => ['user.name' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'article.id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->name])
              ->andFilterWhere(['like', 'article.title', $this->title]);

        return $dataProvider;
    }
}
