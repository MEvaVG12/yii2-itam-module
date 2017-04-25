<?php

namespace marqu3s\itam\models;

use marqu3s\itam\Module;
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
        return array_merge(parent::rules(), [
            [['id', 'id_asset', 'id_os', 'id_office_suite'], 'integer'],
            [['user'], 'safe'],
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
        $query = AssetWorkstation::find();

        # Add conditions that should always apply here
        # Join with asset and asset.location
        $query->joinWith(['asset', 'asset.location', 'os', 'officeSuite']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        # Important: here is how we set up the sorting
        # The key is the attribute name on our "Search" instance
        $dataProvider->sort->attributes = [
            'locationName' => [
                'asc' => ['itam_location.name' => SORT_ASC, 'itam_asset.room' => SORT_ASC],
                'desc' => ['itam_location.name' => SORT_DESC, 'itam_asset.room' => SORT_DESC],
            ],
            /*'room' => [
                'asc' => ['itam_asset.room' => SORT_ASC],
                'desc' => ['itam_asset.room' => SORT_DESC],
            ],*/
            'hostname' => [
                'asc' => ['itam_asset.hostname' => SORT_ASC],
                'desc' => ['itam_asset.hostname' => SORT_DESC],
            ],
            'osName' => [
                'asc' => ['itam_os.name' => SORT_ASC],
                'desc' => ['itam_os.name' => SORT_DESC],
            ],
            'officeSuiteName' => [
                'asc' => ['itam_office_suite.name' => SORT_ASC],
                'desc' => ['itam_office_suite.name' => SORT_DESC],
            ],
            'ipAddress' => [
                'asc' => ['itam_asset.ip_address' => SORT_ASC, 'itam_asset.mac_address' => SORT_ASC],
                'desc' => ['itam_asset.ip_address' => SORT_DESC, 'itam_asset.mac_address' => SORT_DESC],
            ],
            /*'macAddress' => [
                'asc' => ['itam_asset.mac_address' => SORT_ASC],
                'desc' => ['itam_asset.mac_address' => SORT_DESC],
            ],*/
            'brand' => [
                'asc' => ['itam_asset.brand' => SORT_ASC],
                'desc' => ['itam_asset.brand' => SORT_DESC],
            ],
            'model' => [
                'asc' => ['itam_asset.model' => SORT_ASC],
                'desc' => ['itam_asset.model' => SORT_DESC],
            ],
            'user' => [
                'asc' => ['itam_asset_workstation.user' => SORT_ASC],
                'desc' => ['itam_asset_workstation.user' => SORT_DESC],
            ],
        ];


        $this->load($params);

        # No search? Then return data Provider
        if (!$this->validate()) {
            # Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        # Grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_asset' => $this->id_asset,
            'id_office_suite' => $this->id_office_suite,
            'id_os' => $this->id_os,
        ])

        # Here we search the attributes of our relations using our previously configured ones in "AssetWorkstationSearch"
        ->andWhere("(itam_location.name like '%$this->locationName%' OR itam_asset.room like '%$this->locationName%')")
        //->andFilterWhere(['like', 'itam_asset.room', $this->room])
        ->andFilterWhere(['like', 'itam_asset.hostname', $this->hostname])
        ->andFilterWhere(['like', 'itam_os.name', $this->osName])
        ->andFilterWhere(['like', 'itam_office_suite.name', $this->officeSuiteName])
        ->andWhere("(itam_asset.ip_address like '%$this->ipAddress%' OR itam_asset.mac_address like '%$this->macAddress%')")
        //->andFilterWhere(['like', 'itam_asset.mac_address', $this->macAddress])
        ->andFilterWhere(['like', 'itam_asset.brand', $this->brand])
        ->andFilterWhere(['like', 'itam_asset.model', $this->model])
        ->andFilterWhere(['like', 'user', $this->user])
        ;

        return $dataProvider;
    }
}
