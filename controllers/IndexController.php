<?php

namespace app\controllers;

use app\components\ChangeManager;
use app\models\Coin;
use app\models\Credit;
use app\models\UserCoin;
use app\models\VmCoin;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class IndexController
 *
 * @package app\controllers
 */
class IndexController extends \yii\web\Controller
{
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index', [
			'userCoins' => new ActiveDataProvider(['query' => UserCoin::find(),]),
			'vmCoins' => new ActiveDataProvider(['query' => VmCoin::find(),]),
			'credit' => Credit::find()->one(),
		]);
	}
	
	/**
	 * @param int $id
	 */
	public function actionInsertCoin($id)
	{
		$transaction = Yii::$app->db->beginTransaction();
		
		$coin = Coin::findOne($id);
		$credit = Credit::find()->one();
		$coin->userCoin->modify(-1);
		$coin->vmCoin->modify(1);
		$credit->modify($coin->value);
		
		$transaction->commit();
		$this->actionIndex();
	}
	
	public function actionWithdraw()
	{
		$coins = Coin::find()->joinWith('vmCoin')->orderBy(['value' => SORT_DESC])->indexBy('id')->all();
		$credit = Credit::find()->one();
		
		$change = ChangeManager::change($credit->value, ArrayHelper::getColumn($coins, 'value'), ArrayHelper::getColumn($coins, 'vmCoin.count'));
		
		$transaction = Yii::$app->db->beginTransaction();
		
		foreach ($change as $id => $count) {
			$coin = $coins[$id];
			$coin->userCoin->modify($count);
			$coin->vmCoin->modify(-$count);
			$credit->modify(-$coin->value * $count);
		}
		
		$transaction->commit();
		$this->actionIndex();
		
	}
	
	/**
	 * @param int $id
	 */
	public function actionBuy($id)
	{
	
	}
	
}
