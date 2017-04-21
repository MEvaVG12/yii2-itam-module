<?php

use marqu3s\itam\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Os */

$this->title = Module::t('app', 'Create Os');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
