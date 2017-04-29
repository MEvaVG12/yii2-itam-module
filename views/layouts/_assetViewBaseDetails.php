<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 14:59
 */

use marqu3s\itam\Module;
use yii\widgets\DetailView;

/** @var $model \marqu3s\itam\models\AssetWorkstation */
?>
<h2><?= Module::t('app', 'Asset Base Info') ?></h2>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'asset.hostname',
        [
            'label' => Module::t('model', 'Location name'),
            'value' => $model->asset->location->name,
        ],
        'asset.room',
        'asset.brand',
        'asset.model',
        'asset.service_tag',
        'asset.ip_address',
        'asset.mac_address',
    ],
]) ?>
