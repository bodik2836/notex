<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the contact form.
 */
class RegisterForm extends Model
{
    public $name;
    public $surname;
    public $email;
    public $pass;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'surname', 'email', 'pass'], 'required', 'message' => 'Поле "{attribute}" не може бути порожнім.'],
            // email has to be a valid email address
            ['email', 'email'],

            ['email', 'validateEmail'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
            'name' => 'Ім\'я',
            'surname' => 'Прізвище',
            'email' => 'E-mail',
            'pass' => 'Пароль'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = UserIdentity::findByEmail($this->email);
            //var_dump($user);exit();
            if (!is_null($user)) {
                $this->addError($attribute, 'Користувач з такою поштою уже зареєстрований.');
            }
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @return bool whether the model passes validation
     */
    public function register()
    {
        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'pass' => $this->pass
        ];

        $valid = UserIdentity::findByEmail($this->email);

        if ($this->validate() && empty($valid)) {
            $user = new User();
            $user->addUser($data);

            return true;
        }
        return false;
    }
}
