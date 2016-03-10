<?php

namespace app\models;


use Yii;
use yii\base\Model;
use app\models\Transaction;


class TransactionForm extends Model
{
    public $id;
    public $name;
    public $time;
    public $status;
    public $user_id;
    public $url = 'http://test.oneclickmoney.ru/index.php?r=request';


    public function rules()
    {
        return [
            //['name', 'filter', 'filter' => 'trim'],
            [['name', 'time', 'status'], 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            [['time', 'status'], 'integer'],
            //['name', 'unique'],
        ];
    }


    public function attributeLabels()
    {
        return [
          //  'name' => 'Название транзакции',
           // 'time' => 'Время жизни',
           // 'status' => 'Ожидаемый статус',
        ];
    }

    public function create()
    {
        $trans = new Transaction();

        $trans->name = $this->name;
        $trans->time = $this->time;
        $trans->status = $this->status;
        $trans->user_id = Yii::$app->user->identity->id;

        return $trans->save() ? $trans : null;
        //return $trans;

    }

    public static function getTransactions()
    {
        $id = Yii::$app->user->identity->id;
        return Transaction::find()->where(['user_id' => $id])->all();
    }

    public function send($trans)
    {

        $data = '<xml>
                    <action>send</action>
                    <app>leg</app>
                    <transaction id="5" ttl="'.$this->time.'" status="'.$trans->status.'" description="'.$trans->name.'" />
                    <user>
                        <id>'.$trans->user_id.'</id>
                        <name>'.Yii::$app->user->identity->username.'</name>
                    </user>
                </xml>';

        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POST,           true );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $data ); 
        $result=curl_exec ($ch);

        return $result;
    }

    public function check($id)
    {
        
        $data = '<xml>
                    <action>status</action>
                    <app>leg</app>
                    <transaction id="'.$id.'" />
                </xml>';

        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POST,           true );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $data ); 
        $result=curl_exec ($ch);

        return $data.' '.$result;
    }
}