<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wallet */

$this->title = 'Update User Coin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Coins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-coin-update">

	<h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
