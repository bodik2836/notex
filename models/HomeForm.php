<?php


namespace app\models;

use yii\base\Model;

class HomeForm extends Model
{
    public $message;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['message'], 'required', 'message' => 'Це поле не може бути порожнім.'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'message' => 'Про що зараз думаєш?',
        ];
    }

    public function addPost($id)
    {
        $data = [
            'message' => $this->message,
            'id' => $id
        ];


        if ($this->validate()) {
            $post = new Posts();
            $post->setPost($data);

            return true;
        }

        return false;
    }
}