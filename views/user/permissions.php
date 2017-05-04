<?php

use marqu3s\itam\Module;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $users marqu3s\itam\models\User[] */
/* @var $user marqu3s\itam\models\User */
/* @var $userRoles \yii\rbac\Role[] */
/* @var $availableRoles \yii\rbac\Role[] */

$js = <<<JS
    $('#idUser').change(function() {
        window.location.href = '/itam/user/permissions?idUser=' + $(this).val();
    });
JS;
$this->registerJs($js);

$this->title = Module::t('app', 'Users Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="well">
        <?= Module::t('app', 'Choose a User to set permissions:') ?>
        <?= Html::dropDownList('idUser', $user !== null ? $user->id : null, ArrayHelper::map($users, 'id', 'name'), ['prompt' => '--', 'id' => 'idUser']) ?>
    </div>

    <?php if ($user !== null): ?>

        <?php echo $form = Html::beginForm() ?>
            <?= Html::checkboxList('roles',  array_keys($userRoles), ArrayHelper::map($availableRoles, 'name', 'description'), ['separator' => '<br>']); ?>
            <br>
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?php Html::endForm() ?>

    <?php endif ?>

</div>
