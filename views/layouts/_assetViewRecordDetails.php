<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 14:53
 */

use marqu3s\itam\Module;
use yii\widgets\DetailView;

/** @var $model \marqu3s\itam\models\AssetWorkstation */
?>
<h2><?= Module::t('app', 'Record Details') ?></h2>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'asset.created_at:datetime', // creation date formatted as datetime
        'asset.created_by',
        'asset.updated_at:datetime', // update date formatted as datetime
        'asset.updated_by',
    ],
]) ?>
