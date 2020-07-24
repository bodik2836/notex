<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string $user_name
 * @property string $user_surname
 * @property string $user_email
 * @property string $user_pass
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'user_surname', 'user_email', 'user_pass'], 'required'],
            [['user_pass'], 'string'],
            [['user_name', 'user_surname', 'user_email'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'UserIdentity ID',
            'user_name' => 'UserIdentity Name',
            'user_surname' => 'UserIdentity Surname',
            'user_email' => 'UserIdentity Email',
            'user_pass' => 'UserIdentity Pass',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
        ];
    }

    public function addUser($data)
    {
        $this->user_name = $data['name'];
        $this->user_surname = $data['surname'];
        $this->user_email = $data['email'];
        $this->user_pass = md5($data['pass']);

        $this->save();
    }
}
