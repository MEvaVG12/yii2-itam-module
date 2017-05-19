<?php

namespace marqu3s\itam\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MonitorSearch represents the model behind the search form about `marqu3s\itam\models\Monitor`.
 */
class MonitorSearch extends Monitor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fail_count', 'up'], 'integer'],
            [['hostname', 'description', 'check_type', 'socket_port', 'socket_timout', 'ping_count', 'ping_timeout'], 'safe'],
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
        $query = Monitor::find();

        // add conditions that should always apply here
        $query->joinWith(['asset']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        # Important: here is how we set up the sorting
        # The key is the attribute name on our "Search" instance
        $dataProvider->sort->attributes = [
            'hostname' => [
                'asc' => ['itam_asset.hostname' => SORT_ASC],
                'desc' => ['itam_asset.hostname' => SORT_DESC],
            ],
            'description' => [
                'asc' => ['description' => SORT_ASC],
                'desc' => ['description' => SORT_DESC],
            ],
            'check_type' => [
                'asc' => ['check_type' => SORT_ASC],
                'desc' => ['check_type' => SORT_DESC],
            ],
            'socket_port' => [
                'asc' => ['socket_port' => SORT_ASC],
                'desc' => ['socket_port' => SORT_DESC],
            ],
            'socket_timeout' => [
                'asc' => ['socket_timeout' => SORT_ASC],
                'desc' => ['socket_timeout' => SORT_DESC],
            ],
            'ping_count' => [
                'asc' => ['ping_count' => SORT_ASC],
                'desc' => ['ping_count' => SORT_DESC],
            ],
            'ping_timeout' => [
                'asc' => ['ping_timeout' => SORT_ASC],
                'desc' => ['ping_timeout' => SORT_DESC],
            ],
            'up' => [
                'asc' => ['up' => SORT_ASC],
                'desc' => ['up' => SORT_DESC],
            ],
            'fail_count' => [
                'asc' => ['fail_count' => SORT_ASC],
                'desc' => ['fail_count' => SORT_DESC],
            ],
        ];
        $dataProvider->sort->defaultOrder = [
            'up' => SORT_ASC,
            'fail_count' => SORT_DESC,
            'hostname' => SORT_ASC
        ];

        //$this->load($params);
        $dataProvider = $this->loadWithFilters($params, $dataProvider); // From SaveGridFiltersBehavior

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'check_type' => $this->check_type,
            'up' => $this->up,
            'fail_count' => $this->fail_count,
        ]);

        if (!empty($this->hostname)) {
            $query->andFilterWhere(['like', 'itam_asset.hostname', $this->hostname]);
        }
        if (!empty($this->description)) {
            $query->andFilterWhere(['like', 'description', $this->description]);
        }

        return $dataProvider;
    }
}
