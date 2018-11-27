<?php

/** @var $this \yii\web\View */
/** @var $userCoins UserCoin[] */
/** @var $vmCoins VmCoin[] */
/** @var $vmProducts VmProduct[] */

/** @var $credit Credit */

use app\models\Credit;
use app\models\UserCoin;
use app\models\VmCoin;
use app\models\VmProduct;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="row">
	<?php Pjax::begin(['timeout' => 10000, 'enableReplaceState' => false, 'enablePushState' => false,]) ?>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">You have:</h3>
			</div>
			<div class="panel-body">
				<div class="user-coin-view">
					<?= GridView::widget([
						'dataProvider' => $userCoins,
						'summary' => '',
						'columns' => [
							'coin.title',
							'count',
							[
								'class' => 'yii\grid\ActionColumn',
								'buttons' => [
									'update' => function ($url, UserCoin $model, $key) {
										return Html::a('<i class="glyphicon glyphicon-download"></i> Insert coin',
											['insert-coin', 'id' => $model->coin_id], ['class' => 'badge btn']);
									},
								],
								'template' => '{update}',
							],
						],
					]); ?>

				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Products</h3>
			</div>
			<div class="panel-body">
				<?= GridView::widget([
					'dataProvider' => $vmProducts,
					'summary' => '',
					'showHeader' => false,
					'columns' => [
						'title',
						'price',
						'count',
						[
							'class' => 'yii\grid\ActionColumn',
							'buttons' => [
								'update' => function ($url, VmProduct $model, $key) use ($credit) {
									return Html::a('<i class="glyphicon glyphicon-plus-sign"></i> Buy', ['insert-coin', 'id' => $model->id],
										['class' => 'btn btn-primary ' . ($credit->value < $model->price ? 'disabled' : '')]);
								},
							],
							'template' => '{update}',
						],
					
					],
				]); ?>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Vending Machine</h3>
			</div>
			<div class="panel-body">
				<div class="user-coin-view">
					<div class="well">
						Your credit:
						<span class="badge"><?= $credit->value ?> рублей</span>
					</div>
					<?= Html::a('withdraw', ['withdraw'], ['class' => 'btn btn-primary']); ?>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Vending Coins</h3>
			</div>
			<div class="panel-body">
				<?= GridView::widget([
					'dataProvider' => $vmCoins,
					'summary' => '',
					'columns' => [
						'coin.title',
						'count',
					],
				]); ?>
			</div>
		</div>
	</div>
	<?php Pjax::end() ?>
</div>
