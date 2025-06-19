<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Article;
use Yii;

class ArticleForm extends Model
{
    public $title;
    public $content;

    /** @var Article|null */
    public ?Article $article = null;

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            ['title', 'string', 'max' => 255],
            ['content', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'content' => 'Зміст статті',
        ];
    }

    public function loadFromModel(Article $article): void
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->content = $article->content;
    }


    public function save(): ?Article
    {
        $article = $this->article ?? new Article();
        $article->doctor_id = Yii::$app->user->identity->id;
        $article->title = $this->title;
        $article->content = $this->content;

        if ($article->isNewRecord) {
            $article->status = 'reviewing';
            $article->created_at = date('Y-m-d H:i:s');
            $article->updated_at = date('Y-m-d H:i:s');
        } else {
            $article->updated_at = date('Y-m-d H:i:s');
        }
        
        if ($article->save()) {
            return $article;
        }

        Yii::error($article->getErrors(), 'article-form-save');
        return null;
    }
}
