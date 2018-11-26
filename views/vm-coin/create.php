<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VmCoin */

$this->title = 'Create Vm Coin';
$this->params['breadcrumbs'][] = ['label' => 'Vm Coins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vm-coin-create">

	<h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
