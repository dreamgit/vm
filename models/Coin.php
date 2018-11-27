<?php

namespace app\models;

/**
 * This is the model class for table "coin".
 *
 * @property int $id
 * @property string $title
 * @property int $value
 * @property UserCoin $userCoin
 * @property VmCoin $vmCoin
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
	public function getUserCoin()
	{
		return $this->hasOne(UserCoin::className(), ['coin_id' => 'id']);
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVmCoin()
	{
		return $this->hasOne(VmCoin::className(), ['coin_id' => 'id']);
	}
	
	/**
	 * @param $count
	 * @param bool $direction True: from user to vm, false: from vm to user
	 *
	 * @throws \yii\base\Exception
	 */
	public function updateCoinCounts($count, $direction): void
	{
		$this->userCoin->modify($direction ? -$count : $count);
		$this->vmCoin->modify($direction ? $count : -$count);
	}
	
	/**
	 * @param bool $returnAQ
	 *
	 * @return \yii\db\ActiveQuery|Coin[]
	 */
	public static function getCoins($returnAQ = false)
	{
		$query = self::find()
			->joinWith(['vmCoin', 'userCoin'])
			->orderBy(['value' => SORT_DESC])
			->indexBy('id');
		
		return $returnAQ ? $query : $query->all();
	}
}
