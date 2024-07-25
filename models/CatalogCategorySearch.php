<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatalogCategory;

/**
 * CatalogCategorySearch represents the model behind the search form of `app\models\CatalogCategory`.
 */
class CatalogCategorySearch extends CatalogCategory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'order_id', 'state'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at', 'data'], 'safe'],
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
        $query = CatalogCategory::find();

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
            'parent_id' => $this->parent_id,
            'order_id' => $this->order_id,
            'state' => $this->state,
        ]);
        if (!empty($this->parent_id)) {
            $query->andFilterWhere(['parent_id' => $this->parent_id]);
        } else {
            $query->andWhere(['parent_id' => null]);
        }

        $query->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
}
