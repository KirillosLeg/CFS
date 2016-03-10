<?php

namespace app\models;

use Yii;
use yii\base\Model;


class RegForm extends Model
{
    public $username;
    public $password;


    public function rules()
    {
        return [
           // [['username', 'password'], 'filter'],
            [['username', 'password'], 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 3, 'max' => 255],
           // ['username', 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    public function reg()
    {
    	$user = new User();
    	$user->username = $this->username;
    	$user->password = $this->password;
    	$user->generateAuthKey();

    	return $user->save() ? $user : null;

    }

}