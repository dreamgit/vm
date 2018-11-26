<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserCoin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-coin-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'coin_id')->textInput() ?>
	
	<?= $form->field($model, 'count')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>
