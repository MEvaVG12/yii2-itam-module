<?php

use marqu3s\itam\Module;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model marqu3s\itam\models\Group */

$this->title = Module::t('app', 'Create Group');
$this->params['breadcrumbs'][] = ['label' => Module::t('menu', 'Asset Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
