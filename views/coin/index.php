<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CoinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coin-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php Pjax::begin(); ?>

	<p>
		<?= Html::a('Create Coin', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'id',
			'title',
			'value',
			['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',],
		],
	]); ?>
	<?php Pjax::end(); ?>
</div>
