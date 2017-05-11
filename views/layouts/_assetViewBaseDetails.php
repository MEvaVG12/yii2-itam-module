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
        'asset.serial_number',
        'asset.service_tag',
        'asset.ip_address',
        'asset.mac_address',
        [
            'label' => Module::t('app', 'Installed Softwares'),
            'format' => 'html',
            'value' => function ($model) {
                if (count($model->asset->installedSoftwares) == 0) {
                    return null;
                } else {
                    $str = '';
                    foreach ($model->asset->installedSoftwares as $item) {
                        $str .= '<p>';
                        $str .= $item->software->name . '<br>';
                        $str .= '<small>' . $item->softwareLicense->key . '</small>';
                        $str .= '</p>';
                    }
                    return $str;
                }
            }
        ],
        [
            'label' => Module::t('app', 'Belongs to groups'),
            'format' => 'html',
            'value' => function ($model) {
                if (count($model->asset->groups) == 0) {
                    return null;
                } else {
                    $str = '';
                    foreach ($model->asset->groups as $item) {
                        $str .= $item->group->name . '<br>';
                    }
                    return $str;
                }
            }
        ],
        'asset.annotations',
    ],
]) ?>
