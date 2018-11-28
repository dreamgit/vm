<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vm Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vm-product-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php Pjax::begin(); ?>
	<p>
		<?= Html::a('Create Vm Product', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'id',
			'title',
			'count',
			'price',
			['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',],
		],
	]); ?>
	<?php Pjax::end(); ?>
</div>
