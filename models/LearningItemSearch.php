<?php

namespace app\models;

use app\models\LearningItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * LearningItemSearch represents the model behind the search form of `app\models\LearningItem`.
 */
class LearningItemSearch extends LearningItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'learning_category_id'], 'integer'],
            [['code', 'name', 'type', 'created_at', 'updated_at', 'data'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return array_merge(Model::scenarios(), ['search' => array_keys($this->getAttributes())]);
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
        $query = LearningItem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $this->setScenario('search');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'learning_category_id' => $this->learning_category_id,
        ]);

        $query->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'type', $this->type]);

        return $dataProvider;
    }
}
