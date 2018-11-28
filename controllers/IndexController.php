<?php

namespace app\controllers;

use app\components\ChangeManager;
use app\models\Coin;
use app\models\Credit;
use app\models\Product;
use app\models\Wallet;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper as AH;

/**
 * Class IndexController
 *
 * @package app\controllers
 * @property null|\app\models\Credit $credit
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
			'userWallets' => new ActiveDataProvider(['query' => Wallet::find()->where(['type' => 'user']),]),
			'Wallets' => new ActiveDataProvider(['query' => Wallet::find()->where(['type' => 'vm']),]),
			'vmProducts' => new ActiveDataProvider(['query' => Product::find(),]),
			'credit' => $this->credit,
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
			$this->credit->modify($coin->value);
			
			$transaction->commit();
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr!: ' . $e->getMessage());
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
			
			$coins = Coin::getCoins('vmWallet');
			$withdrawCoins = ChangeManager::change($this->credit->value, AH::getColumn($coins, 'value'), AH::getColumn($coins, 'vmWallet.count'));
			$sum = 0;
			foreach ($withdrawCoins as $id => $count) {
				$coin = $coins[$id];
				$coin->updateCoinCounts($count, false);
				$sum += $coin->value * $count;
			}
			$this->credit->modify(-$sum);
			
			$transaction->commit();
			Yii::$app->session->setFlash('success', 'Withdraw done. You got ' . $sum . ' p.');
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr!: ' . $e->getMessage());
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
			
			$product = Product::findOne($id);
			$product->modify(-1);
			$this->credit->modify(-$product->price);
			
			$transaction->commit();
			Yii::$app->session->setFlash('success', 'Thankyou! You just got one ' . $product->title);
			
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr!: ' . $e->getMessage());
		}
		
		return $this->actionIndex();
	}
	
	/**
	 * @return Credit|null
	 * @throws Exception
	 */
	public function getCredit()
	{
		$model = Credit::find()->one();
		if (!$model) {
			throw new Exception('No credit table');
		}
		
		return $model;
	}
	
}
