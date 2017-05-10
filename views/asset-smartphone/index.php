<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \yii\db\ActiveRecord */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $gridColumns array */

$this->title = Module::t('menu', 'Smartphones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="server-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('app', 'Create Smartphone'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'emptyText' => '--'
        ]); ?>
    <?php Pjax::end(); ?>
</div>
