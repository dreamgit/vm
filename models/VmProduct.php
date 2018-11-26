<?php

namespace app\models;

/**
 * This is the model class for table "vm_product".
 *
 * @property int $id
 * @property string $title
 * @property int $count
 * @property int $price
 */
class VmProduct extends \yii\db\ActiveRecord
{
	
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'vm_product';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['count', 'price'], 'integer'],
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
			'count' => 'Count',
			'price' => 'Price',
		];
	}
}