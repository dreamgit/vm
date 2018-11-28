<?php

namespace app\models;

/**
 * This is the model class for table "wallet".
 *
 * @property int $id
 * @property int $coin_id
 * @property int $count
 * @property string $type
 * @property Coin $coin
 */
class Wallet extends \yii\db\ActiveRecord
{
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'wallet';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['coin_id', 'count'], 'integer'],
			[['type'], 'required'],
			[['type'], 'string'],
			[['coin_id', 'type'], 'unique', 'targetAttribute' => ['coin_id', 'type']],
			[['coin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Coin::className(), 'targetAttribute' => ['coin_id' => 'id']],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'coin_id' => 'Coin ID',
			'count' => 'Count',
			'type' => 'Type',
		];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCoin()
	{
		return $this->hasOne(Coin::className(), ['id' => 'coin_id']);
	}
	
	/**
	 * @param $count
	 *
	 * @throws \yii\base\Exception
	 */
	public function modify($count)
	{
		if ($this->count + $count < 0) {
			throw new \yii\base\Exception('No more coins');
		}
		$this->updateCounters(['count' => $count]);
	}
}
