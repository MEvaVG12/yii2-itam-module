<?php

namespace marqu3s\itam\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AssetAccessPointSearch represents the model behind the search form about `marqu3s\itam\models\AssetAccessPoint`.
 */
class AssetAccessPointSearch extends AssetAccessPoint
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'id_asset'], 'integer'],
        ]);
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
        $query = AssetAccessPoint::find();

        # Add conditions that should always apply here
        # Join with asset, asset.location and asset.groups
        $query->joinWith(['asset', 'asset.location', 'asset.groups']);

        # Group by asset hostname because assets can belong to more than one group
        # and this can return a total number of items that is wrong.
        $query->groupBy(['itam_asset.hostname']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $this->getGridPage(),
                //'pageSize' => 3 // 3 for testing purposes, 20 is the default
            ]
        ]);

        # Important: here is how we set up the sorting
        # The key is the attribute name on our "Search" instance
        $dataProvider->sort->attributes = [
            'locationName' => [
                'asc' => ['itam_location.name' => SORT_ASC, 'itam_asset.room' => SORT_ASC],
                'desc' => ['itam_location.name' => SORT_DESC, 'itam_asset.room' => SORT_DESC],
            ],
            'hostname' => [
                'asc' => ['itam_asset.hostname' => SORT_ASC],
                'desc' => ['itam_asset.hostname' => SORT_DESC],
            ],
            'ipMacAddress' => [
                'asc' => ['itam_asset.ip_address' => SORT_ASC, 'itam_asset.mac_address' => SORT_ASC],
                'desc' => ['itam_asset.ip_address' => SORT_DESC, 'itam_asset.mac_address' => SORT_DESC],
            ],
            'brandAndModel' => [
                'asc' => ['itam_asset.brand' => SORT_ASC, 'itam_asset.model' => SORT_ASC],
                'desc' => ['itam_asset.brand' => SORT_DESC, 'itam_asset.model' => SORT_DESC],
            ],
            'group' => [
                'asc' => ['itam_group.name' => SORT_ASC],
                'desc' => ['itam_group.name' => SORT_DESC],
            ],
        ];
        $dataProvider->sort->defaultOrder = [
            'hostname' => SORT_ASC
        ];

        //$this->load($params);
        $dataProvider = $this->loadWithFilters($params, $dataProvider); // From SaveGridFiltersBehavior

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        # grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_asset' => $this->id_asset,
            'itam_group_asset.id_group' => $this->group,
        ]);

        # Here we search the attributes of our relations using our previously configured ones in "AssetServerSearch"
        $query->andFilterWhere(['like', 'itam_asset.hostname', $this->hostname]);
        if (!empty($this->locationName)) {
            $query->andWhere("(itam_location.name like '%$this->locationName%' OR itam_asset.room like '%$this->locationName%')");
        }
        if (!empty($this->ipMacAddress)) {
            $query->andWhere("(itam_asset.ip_address like '%$this->ipMacAddress%' OR itam_asset.mac_address like '%$this->ipMacAddress%')");
        }
        if (!empty($this->brandAndModel)) {
            $query->andWhere("(itam_asset.brand like '%$this->brandAndModel%' OR itam_asset.model like '%$this->brandAndModel%')");
        }

        return $dataProvider;
    }
}
