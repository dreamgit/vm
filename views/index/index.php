<?php

/** @var $this \yii\web\View */
/** @var $userCoins UserCoin[] */
/** @var $vmCoins VmCoin[] */

/** @var $credit Credit */

use app\models\Credit;
use app\models\UserCoin;
use app\models\VmCoin;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<?= Html::a('coin', ['/coin']) ?><br>
<?= Html::a('user-coin', ['/user-coin']) ?><br>
<?= Html::a('vm-coin', ['/vm-coin']) ?><br>
<?= Html::a('vm-product', ['/vm-product']) ?>

<div class="row">
	<?php Pjax::begin(['timeout' => 10000, 'enableReplaceState' => false, 'enablePushState' => false,]) ?>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
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
								return Html::a('+', ['insert-coin', 'id' => $model->coin_id]);
							},
						],
						'template' => '{update}',
					],
				
				],
			]); ?>

		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<?= GridView::widget([
			'dataProvider' => $vmCoins,
			'summary' => '',
			'columns' => [
				'coin.title',
				'count',
			],
		]); ?>

		<div class="well">
			<p>Your credit</p>
			<p><?= $credit->value ?></p>
			<?= Html::a('withdraw', ['withdraw']); ?>
		</div>
	</div>
	<?php Pjax::end() ?>
</div>
