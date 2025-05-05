<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShortUrl;

/**
 * SortUrlSearch represents the model behind the search form of `app\models\ShortUrl`.
 */
class ShortUrlSearch extends ShortUrl
{
    /**
     * {@inheritdoc}
     */
	public $hits_count;
	
    public function rules()
    {
        return [
            [['id','hits_count'], 'integer'],
            [['original_url', 'short_code', 'created_at'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
	public function search($params, $formName = null)
	{
		$query = self::find()
			->select(['short_url.*', 'COUNT(url_access_log.id) AS hits_count'])
			->leftJoin('url_access_log', 'url_access_log.short_url_id = short_url.id')
			->groupBy('short_url.id');

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params, $formName);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'short_url.id' => $this->id,
			'short_url.created_at' => $this->created_at,
		]);

		$query->andFilterWhere(['like', 'short_url.original_url', $this->original_url])
			  ->andFilterWhere(['like', 'short_url.short_code', $this->short_code]);

		return $dataProvider;
	}
}
