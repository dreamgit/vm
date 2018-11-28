<?php

namespace app\models;

/**
 * This is the model class for table "credit".
 *
 * @property int $value
 */
class Credit extends \yii\db\ActiveRecord
{
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'credit';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['value'], 'integer'],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'value' => 'Value',
		];
	}
	
	/**
	 * @param $count
	 *
	 * @throws \yii\base\Exception
	 */
	public function modify($count)
	{
		if ($this->value + $count < 0) {
			throw new \yii\base\Exception('No more credits');
		}
		$this->updateCounters(['value' => $count]);
	}
}
