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
			throw new \yii\base\Exception('1113');
		}
		$this->updateCounters(['value' => $count]);
	}
	
	/**
	 * @return Credit
	 * @throws \yii\base\Exception
	 */
	public static function getCredit()
	{
		$model = self::find()->one();
		if (!$model) {
			throw new \yii\base\Exception('1114');
		}
		
		return $model;
	}
}
