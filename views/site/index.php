<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>

<div class="site-index">

<?php
if(Yii::$app->user->isGuest) {
        echo 'chechetka IN<br>'        

        . Html::a('LoginIN', ['/site/login'], ['class' => 'link'])
        
        . ' ' . Html::a('Registration', ['/site/reg']);

    } else {
        
        echo 'chechetka OUT<br>'
        . Yii::$app->user->identity->username
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton('=>', ['class' => 'link'])
        . Html::endForm()
        . '<br>' . Html::a('GoGo', ['/trans/transaction']);
    }

?>

</div>
