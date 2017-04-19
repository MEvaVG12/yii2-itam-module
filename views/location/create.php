<?php

use marqu3s\itam\Module;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\itam\models\Location */

$this->title = Module::t('app', 'Create Location');
$this->params['breadcrumbs'][] = ['label' => Module::t('app', 'Locations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
