<?php

namespace app\models;

/**
 * This is the model class for table "coin".
 *
 * @property int $id
 * @property string $title
 * @property int $value
 * @property \yii\db\ActiveQuery|Wallet $vmWallet
 * @property \yii\db\ActiveQuery $wallet
 * @property \yii\db\ActiveQuery|Wallet $userWallet
 */
class Coin extends \yii\db\ActiveRecord
{
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'coin';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title', 'value'], 'required'],
			[['value'], 'integer'],
			[['title'], 'string', 'max' => 64],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'title' => 'Title',
			'value' => 'Value',
		];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserWallet()
	{
		return $this->hasOne(Wallet::className(), ['coin_id' => 'id'])->andWhere(['type' => 'user']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVmWallet()
	{
		return $this->hasOne(Wallet::className(), ['coin_id' => 'id'])->andWhere(['type' => 'vm']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getWallet()
	{
		return $this->hasOne(Wallet::className(), ['coin_id' => 'id']);
	}
	
	/**
	 * @param $count
	 * @param bool $direction True: from user to vm, false: from vm to user
	 *
	 * @throws \yii\base\Exception
	 */
	public function updateCoinCounts($count, $direction): void
	{
		$this->userWallet->modify($direction ? -$count : $count);
		$this->vmWallet->modify($direction ? $count : -$count);
	}
	
	/**
	 * @param null $type
	 *
	 * @return \yii\db\ActiveQuery|Coin[]
	 */
	public static function getCoins($type = null)
	{
		return self::find()
			->joinWith($type)
			->orderBy(['value' => SORT_DESC])
			->indexBy('id')->all();
	}
}
