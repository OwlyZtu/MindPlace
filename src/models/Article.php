<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $content
 * @property string $status
 *
 * @property User $doctor
 */
class Article extends ActiveRecord
{
    const STATUS_REVIEWING = 'reviewing';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'doctor_id', 'content'], 'required'],
            [['doctor_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'content'], 'string'],
            ['status', 'in', 'range' => array_keys(self::statusList())],
            [['status'], 'default', 'value' => self::STATUS_REVIEWING],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Лікар',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата оновлення',
            'title' => 'Заголовок',
            'content' => 'Контент',
            'status' => 'Статус',
        ];
    }

    public function getDoctor()
    {
        return $this->hasOne(User::class, ['id' => 'doctor_id']);
    }

    public static function statusList(): array
    {
        return [
            self::STATUS_REVIEWING => 'На перевірці',
            self::STATUS_APPROVED => 'Схвалено',
            self::STATUS_REJECTED => 'Відхилено',
        ];
    }

    public function getStatusName(): string
    {
        return self::statusList()[$this->status];
    }
    
    public static function create(array $data): ?self
    {
        $article = new self();
        if (!$article->validate()) {
            Yii::error($article->getErrors(), 'article-create');
            return null;
        }
        $article->doctor_id = $data['doctor_id'];
        $article->title = $data['title'];
        $article->content = $data['content'];
        return $article->save ? $article : null;
    }

    public function updateArticle(array $data): bool
    {
        if ($this->load($data, '') && $this->save()) {
            return true;
        }
        Yii::error($this->getErrors(), 'article-update');
        return false;
    }

    public function updateStatus($status): bool
    {
        $this->status = $status;
        if( $this->save()) {
            return true;
        }
        Yii::error($this->getErrors(), 'article-update-status');
        return false;
    }

    public function deleteArticle(): bool
    {
        return $this->delete() !== false;
    }


    public static function getById($id): ?self
    {
        return self::findOne($id);
    }

    public static function getAllByDoctor($doctorId)
    {
        return self::find()->where(['doctor_id' => $doctorId])->orderBy(['updated_at' => SORT_DESC]);
    }

    public static function getAllApproved()
    {
        return self::find()->where(['status' => self::STATUS_APPROVED])->orderBy(['updated_at' => SORT_DESC]);
    }

    public static function getAllRejected()
    {
        return self::find()->where(['status' => self::STATUS_REJECTED])->orderBy(['updated_at' => SORT_DESC]);
    }

    public static function getAllReviewing()
    {
        return self::find()->where(['status' => self::STATUS_REVIEWING])->orderBy(['updated_at' => SORT_DESC]);
    }

    public static function getAllByStatus($status)
    {
        return self::find()->where(['status' => $status])->orderBy(['updated_at' => SORT_DESC]);
    }
}
