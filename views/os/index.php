<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel marqu3s\itam\models\OsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('menu', 'OSes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('app', 'Create Os'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} &nbsp; {delete}',
                    'header' => Module::t('app', 'Actions'),
                    'headerOptions' => [
                        'style' => 'width: 70px'
                    ],
                    'contentOptions' => [
                        'class' => 'text-center'
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-pencil"></i>', $url, ['title' => Module::t('app', 'Update'), 'data-pjax' => 0]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-trash"></i>', $url, ['title' => Module::t('app', 'Delete'), 'data' => ['pjax' => 0, 'method' => 'post', 'confirm' => Module::t('app', 'Are you sure you want to delete this item?')]]);
                        },
                    ]
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
