<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $post_id
 * @property string $message
 * @property string $date
 * @property int $user_id_id
 *
 * @property User $userId
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'user_id_id'], 'required'],
            [['message'], 'string'],
            [['date'], 'safe'],
            [['user_id_id'], 'integer'],
            [['user_id_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'message' => 'Про що зараз думаєш?',
            'date' => 'Date',
            'user_id_id' => 'User Id ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserId()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id_id']);
    }

    public static function getPosts($id)
    {
        $posts = Posts::find()->where(['user_id_id' => $id])->orderBy(['date' => SORT_DESC])->all();

        for ($i = 0; $i < count($posts); $i++)
        {
            $posts[$i]['message'] = Code::full_decode($posts[$i]['message']);
        }

        return $posts;
    }

    public function setPost($data)
    {
        $this->message = Code::full_encode($data['message']);
        $this->user_id_id = $data['id'];

        $this->save();
    }
}
