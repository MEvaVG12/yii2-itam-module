<?php

namespace marqu3s\itam\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AssetWorkstationSearch represents the model behind the search form about `marqu3s\itam\models\AssetWorkstation`.
 */
class AssetWorkstationSearch extends AssetWorkstation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_asset', 'id_os', 'id_office_suite'], 'integer'],
            [['user'], 'safe'],
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
        $query = AssetWorkstation::find();

        // add conditions that should always apply here
        $query->joinWith(['asset']);

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
            'id_asset' => $this->id_asset,
            'id_office_suite' => $this->id_office_suite,
            'id_os' => $this->id_os,
            'user' => $this->user,
        ]);

        //$query->andFilterWhere(['like', 'room', $this->name]);
        //$query->andFilterWhere(['like', 'hostname', $this->name]);

        return $dataProvider;
    }
}
