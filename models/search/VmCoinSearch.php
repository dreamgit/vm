<?php

namespace app\models\search;

use app\models\VmCoin;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VmCoinSearch represents the model behind the search form of `app\models\VmCoin`.
 */
class VmCoinSearch extends VmCoin
{
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'coin_id', 'count'], 'integer'],
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
		$query = VmCoin::find();
		
		// add conditions that should always apply here
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		
		$this->load($params);
		
		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'coin_id' => $this->coin_id,
			'count' => $this->count,
		]);
		
		return $dataProvider;
	}
}
