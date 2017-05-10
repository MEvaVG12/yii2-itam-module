<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $prefix string */

$this->title = Module::t('app', 'Authorization Setup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authorization-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('app', 'This page must be used only once to create the authorization rules.') ?></p>

    <hr>

    <h2><?= Module::t('app', 'Create the rules') ?></h2>
    <p><?= Module::t('app', 'Authorization item prefix to be used when creating permissions in the database (can be configured in application config/main.php file, in the module settings):') ?> <code><?= $prefix ?></code></p>
    <?php $form = ActiveForm::begin(['action' => ['create-rules']]); ?>
        <?= Html::submitButton(Module::t('app', 'Create Rules'), ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>

    <hr>

    <h2><?= Module::t('app', 'Assign an admin user') ?></h2>
    <p><?= Module::t('app', 'Specify the user ID in your database that will have administrator permission.') ?></p>
    <?php $form = ActiveForm::begin(['action' => ['assign-admin'], 'options' => ['class' => 'form-inline']]); ?>
        <div class="form-group">
            <label><?= Module::t('app', 'Admin User ID')?>: </label>
            <?= Html::input('text', 'user_id', '1', ['class' => 'form-control', 'style' => 'width: 100px;']) ?>
            <?= Html::submitButton(Module::t('app', 'Assign Admin'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end() ?>

</div>
