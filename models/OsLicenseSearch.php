<?php

namespace marqu3s\itam\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OsLicenceSearch represents the model behind the search form about `OsLicence`.
 */
class OsLicenseSearch extends OsLicense
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_os', 'purchased_licenses'], 'integer'],
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
        $query = OsLicense::find();

        // add conditions that should always apply here
        $query->joinWith('os');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        # Important: here is how we set up the sorting
        # The key is the attribute name on our "Search" instance
        $dataProvider->sort->attributes = [
            'key' => [
                'asc' => ['key' => SORT_ASC],
                'desc' => ['key' => SORT_DESC],
            ],
            'purchased_licenses' => [
                'asc' => ['purchased_licenses' => SORT_ASC],
                'desc' => ['purchased_licenses' => SORT_DESC],
            ],
            'id_os' => [
                'asc' => ['itam_os.name' => SORT_ASC],
                'desc' => ['itam_os.name' => SORT_DESC],
            ],
        ];
        $dataProvider->sort->defaultOrder = [
            'id_os' => SORT_ASC
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_os' => $this->id_os,
            'purchased_licenses' => $this->purchased_licenses,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
