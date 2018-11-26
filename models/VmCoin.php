<?php

namespace app\models;

/**
 * This is the model class for table "vm_coin".
 *
 * @property int $id
 * @property int $coin_id
 * @property int $count
 * @property Coin $coin
 */
class VmCoin extends \yii\db\ActiveRecord
{
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'vm_coin';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['coin_id'], 'required'],
			[['coin_id', 'count'], 'integer'],
			[['coin_id'], 'unique'],
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
		];
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCoin()
	{
		return $this->hasOne(Coin::className(), ['id' => 'coin_id']);
	}
}
