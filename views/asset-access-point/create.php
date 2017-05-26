<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\AssetAccessPointForm */

$this->title = Module::t('app', 'Create Access Point');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Access Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
