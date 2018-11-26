<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UserCoinSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-coin-search">
	
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => [
			'data-pjax' => 1,
		],
	]); ?>
	
	<?= $form->field($model, 'id') ?>
	
	<?= $form->field($model, 'coin_id') ?>
	
	<?= $form->field($model, 'count') ?>

	<div class="form-group">
		<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>