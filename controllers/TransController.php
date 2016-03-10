<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TransactionForm;

class TransController extends Controller {
	
	public function actionTransaction()
    {
    	$model = new TransactionForm();
    	// getform db
    	//$transes = $model->getTransactions();

    //	echo $transes;
    	return $this->render('Transaction', ['model' => $model]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCreate() 
    {
        $model = new TransactionForm();

        if($model->load(Yii::$app->request->post())){
            if($trans = $model->create()){
                 $result = $model->send($trans);
                    //$model->delete();
                //return $this->refresh();
                return $this->render('transaction', ['model' => $model]);       
            } else {
                Yii::$app->session->setFlash('error', 'errrrroooor');
                Yii::error('errrooor');
                return $this->refresh();
            }
        } else {
            return $this->render('transaction', ['model' => $model]);       
        }
    }

    public function actionCheck()
    {
        $model = new TransactionForm();

        $model->load(Yii::$app->request->post());
        $a = 0;
        $result = $model->check($a);
        echo $a.$result;

        return $this->render('transaction', ['model' => $model, 'result' => $result]);
    } 
}
?>