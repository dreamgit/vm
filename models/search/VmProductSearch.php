<?php

namespace app\models\search;

use app\models\VmProduct;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VmProductSearch represents the model behind the search form of `app\models\VmProduct`.
 */
class VmProductSearch extends VmProduct
{
	
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'count', 'price'], 'integer'],
			[['title'], 'safe'],
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
		$query = VmProduct::find();
		
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
			'count' => $this->count,
			'price' => $this->price,
		]);
		
		$query->andFilterWhere(['like', 'title', $this->title]);
		
		return $dataProvider;
	}
}
