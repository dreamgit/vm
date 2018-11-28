<?php

namespace app\components;

/**
 * Class ChangeManager
 *
 * @package app\components
 */
class ChangeManager
{
	
	private $coins;
	private $limits;
	private $amount;
	private $changed;
	
	/**
	 * ChangeManager constructor.
	 *
	 * @param $coins
	 * @param null $limits
	 */
	public function __construct($coins, $limits = null)
	{
		if (!isset($coins)) {
			$coins = [];
		}
		if (!isset($limits)) {
			$limits = [];
		}
		$this->limits = $limits;
		$this->coins = $coins;
	}
	
	/**
	 * @param $amount
	 * @param $coins
	 * @param null $limits
	 *
	 * @return array|bool
	 * @throws \yii\base\Exception
	 */
	public static function change($amount, $coins, $limits = null)
	{
		$result = self::groupBy((new ChangeManager($coins, $limits))->getChange($amount));
		if (!$result) {
			throw new \yii\base\Exception('No coins for change');
		}
		
		return $result;
	}
	
	/**
	 * @param $amount
	 *
	 * @return bool|int
	 */
	public function getChange($amount = 0)
	{
		$this->changed = [];
		
		if ($this->isLimited() && count($this->limits) != count($this->coins)) {
			return false;
		}
		
		$this->amount = $amount;
		$this->changed = $this->makeChange($this->amount);
		
		return $this->changed;
	}
	
	/**
	 * @param $coins
	 *
	 * @return array|bool
	 */
	public static function groupBy($coins)
	{
		$groups = [];
		if (!isset($coins) || $coins < 0) {
			return false;
		}
		
		foreach ($coins as $coin) {
			if (!array_key_exists($coin, $groups) && !isset($groups[$coin])) {
				$groups[$coin] = 1;
			} else {
				$counter = $groups[$coin] + 1;
				$groups[$coin] = $counter;
			}
		}
		
		return $groups;
	}
	
	/**
	 * @param $amount
	 *
	 * @return int
	 */
	private function makeChange($amount)
	{
		$maxCoin = 0;
		$sum = 0;
		$limited = $this->isLimited();
		
		while ($sum < $amount) {
			$maxCoin = $this->getLocalMax($amount, $sum);
			if (!isset($maxCoin)) {
				return -1;
			}
			
			if ($limited && $this->checkQuantity($maxCoin)) {
				$this->changed[] = $this->getIndex($maxCoin);
				$this->setQuantity($maxCoin, $this->popQuantity($maxCoin));
				$sum += $maxCoin;
			} elseif (!$limited) {
				$this->changed[] = $this->getIndex($maxCoin);
				$sum += $maxCoin;
			}
		}
		
		return $this->changed;
	}
	
	/**
	 * @param $coin
	 *
	 * @return bool
	 */
	private function checkQuantity($coin)
	{
		$result = true;
		if ($this->getQuantity($coin) <= 0) {
			$result = false;
		}
		
		return $result;
	}
	
	/**
	 * @param $key
	 *
	 * @return false|int|string
	 */
	private function getIndex($key)
	{
		return array_search($key, $this->coins, true);
	}
	
	/**
	 * @param $coin
	 *
	 * @return mixed
	 */
	private function getQuantity($coin)
	{
		$index = $this->getIndex($coin);
		
		return $this->limits[$index];
	}
	
	/**
	 * @param $coin
	 * @param $newQuantity
	 */
	private function setQuantity($coin, $newQuantity)
	{
		$index = $this->getIndex($coin);
		$this->limits[$index] = $newQuantity;
	}
	
	/**
	 * @param $coin
	 *
	 * @return int|mixed
	 */
	private function popQuantity($coin)
	{
		$quantity = $this->getQuantity($coin);
		
		return $quantity - 1;
	}
	
	/**
	 * @param $coin
	 *
	 * @return int|mixed
	 */
	private function pushQuantity($coin)
	{
		$quantity = $this->getQuantity($coin);
		
		return $quantity + 1;
	}
	
	/**
	 * @return bool
	 */
	private function isLimited()
	{
		return !(count($this->limits) <= 0);
	}
	
	/**
	 * @param $amount
	 * @param $sum
	 *
	 * @return mixed|null
	 */
	private function getLocalMax($amount, $sum)
	{
		$max = null;
		foreach ($this->coins as $coin) {
			if (($coin + $sum <= $amount) && (!$this->isLimited() || $this->checkQuantity($coin))) {
				$max = $coin;
				break;
			}
		}
		
		return $max;
	}
}
