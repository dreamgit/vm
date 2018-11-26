<?php

use app\models\Coin;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserCoin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-coin-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'coin_id')->dropDownList(ArrayHelper::map(Coin::find()->all(), 'id', 'title')) ?>
	
	<?= $form->field($model, 'count')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>
	
	<?php ActiveForm::end(); ?>

</div>
