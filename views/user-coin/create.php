<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserCoin */

$this->title = 'Create User Coin';
$this->params['breadcrumbs'][] = ['label' => 'User Coins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-coin-create">

	<h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
