<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VmCoin */

$this->title = 'Update Vm Coin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vm Coins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vm-coin-update">

	<h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
