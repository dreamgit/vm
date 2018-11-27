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
use app\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="row">
	<?php Pjax::begin(['timeout' => 10000, 'enableReplaceState' => false, 'enablePushState' => false,]) ?>
	<?= Alert::widget() ?>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">You have:</h3>
			</div>
			<div class="panel-body">
				<div class="user-coin-view">
					<?= GridView::widget([
						'dataProvider' => $userCoins,
						'summary' => '',
						'showHeader' => false,
						'columns' => [
							'coin.title',
							[
								'attribute' => 'count',
								'value' => function ($model) {
									return $model->count . ' штук';
								},
							],
							[
								'class' => 'yii\grid\ActionColumn',
								'buttons' => [
									'update' => function ($url, UserCoin $model, $key) {
										return $model->count
											? Html::a('<i class="glyphicon glyphicon-download"></i> Insert coin', ['insert-coin', 'id' => $model->coin_id],
												['class' => 'btn btn-success badge'])
											: '';
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
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Vending Machine</h3>
			</div>
			<div class="panel-body">
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
								[
									'attribute' => 'price',
									'value' => function ($model) {
										return $model->price . ' рублей';
									},
								],
								[
									'attribute' => 'count',
									'value' => function ($model) {
										return $model->count . ' штук';
									},
								],
								[
									'class' => 'yii\grid\ActionColumn',
									'buttons' => [
										'update' => function ($url, VmProduct $model, $key) use ($credit) {
											return $credit->value >= $model->price
												? Html::a('<i class="glyphicon glyphicon-plus-sign"></i> Buy', ['buy', 'id' => $model->id],
													['class' => 'btn btn-success btn-sm'])
												: '';
										},
									],
									'template' => '{update}',
								],
							
							],
						]); ?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="user-coin-view">
							<div class="well">
								<h3>Your credit:
									<span class="label label-default"><?= $credit->value ?> p.</span>
								</h3>
							</div>
							<?= Html::a('<i class="glyphicon glyphicon-share-alt"></i> Withdraw', ['withdraw'],
								['class' => 'btn btn-danger ' . (!$credit->value ? 'disabled' : '')]); ?>
						</div>
					</div>
				</div>
				<div class="panel panel-success">
					<div class="panel-body">
						<?= GridView::widget([
							'dataProvider' => $vmCoins,
							'summary' => '',
							'showHeader' => false,
							'columns' => [
								'coin.title',
								[
									'attribute' => 'count',
									'value' => function ($model) {
										return $model->count . ' штук';
									},
								],
							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php Pjax::end() ?>
</div>
