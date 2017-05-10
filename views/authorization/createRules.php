<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $prefix string */

$this->title = Module::t('app', 'Authorization - Create rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authorization-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Module::t('app', 'This page must be used only once to create the authorization rules.') ?></p>
    <p><?= Module::t('app', 'Authorization item prefix to be used when creating permissions in the database (can be configured in application config/main.php file, in the module settings):') ?> <code><?= $prefix ?></code></p>

    <?php $form = ActiveForm::begin(); ?>
    <?= Html::submitButton(Module::t('app', 'Create Rules'), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>

</div>
