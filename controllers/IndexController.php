<?php

namespace app\controllers;

use app\components\ChangeManager;
use app\models\Coin;
use app\models\Credit;
use app\models\UserCoin;
use app\models\VmCoin;
use app\models\VmProduct;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper as AH;

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
			'vmProducts' => new ActiveDataProvider(['query' => VmProduct::find(),]),
			'credit' => Credit::getCredit(),
		]);
	}
	
	/**
	 * @param int $id
	 *
	 * @return string
	 */
	public function actionInsertCoin($id)
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			$coin = Coin::findOne($id);
			$coin->updateCoinCounts(1, true);
			Credit::getCredit()->modify($coin->value);
			
			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr![0]');
		}
		
		return $this->actionIndex();
	}
	
	/**
	 * @return string
	 * @throws \yii\db\Exception
	 */
	public function actionWithdraw()
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			
			$coins = Coin::getCoins();
			$withdrawCoins = ChangeManager::change(Credit::getCredit()->value, AH::getColumn($coins, 'value'), AH::getColumn($coins, 'vmCoin.count'));
			$sum = 0;
			foreach ($withdrawCoins as $id => $count) {
				$coin = $coins[$id];
				$coin->updateCoinCounts($count, false);
				$sum += $coin->value * $count;
			}
			Credit::getCredit()->modify(-$sum);
			
			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr![1]');
		}
		
		return $this->actionIndex();
		
	}
	
	/**
	 * @param int $id
	 *
	 * @return string
	 */
	public function actionBuy($id)
	{
		$transaction = Yii::$app->db->beginTransaction();
		try {
			
			$vmProduct = vmProduct::findOne($id);
			$vmProduct->modify(-1);
			Credit::getCredit()->modify(-$vmProduct->price);
			
			$transaction->commit();
			Yii::$app->session->setFlash('success', 'Thankyou! You just got one ' . $vmProduct->title);
			
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr![2]');
		}
		
		return $this->actionIndex();
	}
}
