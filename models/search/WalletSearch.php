<?php

namespace app\models\search;

use app\models\Wallet;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WalletSearch represents the model behind the search form of `app\models\Wallet`.
 */
class WalletSearch extends Wallet
{
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'coin_id', 'count'], 'integer'],
			[['type'], 'string'],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}
	
	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Wallet::find();
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		
		$this->load($params);
		
		if (!$this->validate()) {
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'coin_id' => $this->coin_id,
			'count' => $this->count,
			'type' => $this->type,
		]);
		
		return $dataProvider;
	}
}
