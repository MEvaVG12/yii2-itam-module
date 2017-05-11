<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 10/05/17
 * Time: 10:54
 */

use marqu3s\itam\Module;
use marqu3s\itam\models\Group;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var $model \marqu3s\itam\models\AssetWorkstationForm */
?>
<?php if (!$model->asset->isNewRecord): ?>
    <h2><?= Module::t('app', 'Belongs to groups') ?></h2>
    <div class="well">
        <?= $form->field($model->asset, 'groupId')->checkboxList(ArrayHelper::map(Group::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), ['separator' => '<br>'])->label(false); ?>
    </div>
<?php endif ?>
