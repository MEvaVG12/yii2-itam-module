<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetSmartphone */

$this->title = Module::t('app', 'Create Smartphone');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Smartphones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smartphone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
