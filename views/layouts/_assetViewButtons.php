<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 29/04/17
 * Time: 15:03
 */

use marqu3s\itam\Module;
use yii\helpers\Html;

/** @var $model \marqu3s\itam\models\AssetWorkstation */
?>
<p>
    <?= Html::a(Module::t('app', 'Index'), ['index'], ['class' => 'btn btn-success']) ?>
    <?= Html::a(Module::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Module::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Module::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</p>
