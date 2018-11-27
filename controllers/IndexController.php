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
			'vmProducts' => new ActiveDataProvider(['query' => VmProduct::find(),]),
			'credit' => Credit::find()->one(),
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
			$credit = Credit::find()->one();
			$coin->userCoin->modify(-1);
			$coin->vmCoin->modify(1);
			$credit->modify($coin->value);
			
			$transaction->commit();
			
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr![1]');
		}
		
		return $this->actionIndex();
	}
	
	/**
	 * @return string
	 * @throws \yii\db\Exception
	 */
	public function actionWithdraw()
	{
		$coins = Coin::find()->joinWith('vmCoin')->orderBy(['value' => SORT_DESC])->indexBy('id')->all();
		$credit = Credit::find()->one();
		
		$change = ChangeManager::change($credit->value, ArrayHelper::getColumn($coins, 'value'), ArrayHelper::getColumn($coins, 'vmCoin.count'));
		
		$transaction = Yii::$app->db->beginTransaction();
		try {
			foreach ($change as $id => $count) {
				$coin = $coins[$id];
				$coin->userCoin->modify($count);
				$coin->vmCoin->modify(-$count);
				$credit->modify(-$coin->value * $count);
			}
			
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
			$credit = Credit::find()->one();
			$credit->modify(-$vmProduct->price);
			$vmProduct->modify(-1);
			
			$transaction->commit();
			
			Yii::$app->session->setFlash('success', 'Thankyou! You just got one ' . $vmProduct->title);
			
		} catch (Exception $e) {
			$transaction->rollBack();
			Yii::$app->session->setFlash('error', 'Erorr![1]');
		}
		
		return $this->actionIndex();
	}
	
}
