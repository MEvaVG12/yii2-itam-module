<?php

namespace marqu3s\itam\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SoftwareLicenceSearch represents the model behind the search form about `SoftwareLicence`.
 */
class SoftwareLicenseSearch extends SoftwareLicense
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_software', 'purchased_licenses'], 'integer'],
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
        $query = SoftwareLicense::find();

        # Add conditions that should always apply here
        # Join with asset and asset.location
        $query->joinWith(['software']);

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
            'id_software' => $this->id_software,
            'purchased_licenses' => $this->purchased_licenses,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
