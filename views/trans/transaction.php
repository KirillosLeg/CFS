<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Transaction';
$this->params['breadcrumbs'][] = $this->title;


$id = Yii::$app->user->identity->id;
?>

<div class="site-transactions">

	<div class="row">

		<div class="user col-lg-4">
			<div class="title">
				<?= Yii::$app->user->identity->username ?>
			</div>
			
	<?php
	
	$form = ActiveForm::begin([
		'action' => ['trans/create'],
        'id' => 'creat-trans-form',
        'options' => ['class' => 'form-create-trans'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<br><div class=\"col-lg-12\">{error}</div><br>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'time')->textInput() ?>
        <?= $form->field($model, 'status')->textInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Create Transaction', ['class' => 'btn btn-primary', 'name' => 'trans-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
		</div>


		<div class="col-lg-8">

			<table id="trans">
				<thead>
					<tr>
						<th>№</th>
						<th>id</th>
						<th>name</th>
						<th>status</th>
						<th>!!!</th>
					</tr>
				</thead>
				<tbody>

				<?php 

					$transes = $model->getTransactions();

					$i = 1;
					foreach ($transes as $trans) {
						echo '<tr>';
						echo '<td>'.$i.'</td>';
						echo '<td>'.$trans->id.'</td>';
						echo '<td>'.$trans->name.'</td>';
						echo '<td>'.$trans->status.'</td>';
						echo '<td>';
						if ($trans->status != 0) {
							$form2 = ActiveForm::begin([
								'action' => ['trans/check'],
								'id' => 'up',
								'fieldConfig' => [
            						'template' => "{input}"],
								
							]);
							echo $form2->field($model, 'id')->hiddenInput(['id' => $trans->id]);	
	            			echo Html::submitButton('Update');
            				ActiveForm::end();
            				/*
							Html::beginForm(['/trans/check'])
								. Html::submitButton('Update', ['class' => 'link'])
        						. Html::endForm(); */
						}
						echo '</td>';
						$i++;
						/*
						foreach ($trans as $val) {
							echo '<td>' . $val . '</td>';
						}
						if ($trans['status'] != 0) {
							echo '<td>';
							/*
								.Html::beginForm(['/trans/check'], 'post')
								. Html::submitButton('Update', ['class' => 'link'])
        						. Html::endForm();
							*/
								//echo 'Update';
						/*		echo HTML::a('Update', ['/trans/check'], ['id' => $trans->id]);
							echo '</td>';
						} else {
							echo '<td></td>';
						}*/
					
						echo '</tr>';
					}
				?>

				</tbody>
			</table>

		</div>


	</div>
</div>