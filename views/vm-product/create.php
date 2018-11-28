<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Create Vm Product';
$this->params['breadcrumbs'][] = ['label' => 'Vm Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vm-product-create">

	<h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
