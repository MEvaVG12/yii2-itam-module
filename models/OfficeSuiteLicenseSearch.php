<?php

namespace marqu3s\itam\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OfficeSuiteLicenseSearch represents the model behind the search form about `OfficeSuiteLicence`.
 */
class OfficeSuiteLicenseSearch extends OfficeSuiteLicense
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_office_suite', 'allowed_activations'], 'integer'],
            [['key'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = OfficeSuiteLicense::find();

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
            'id_office_suite' => $this->id_office_suite,
            'allowed_activations' => $this->allowed_activations,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
