<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 10/05/17
 * Time: 10:47
 */
use marqu3s\itam\Module;
?>
<h2><?= Module::t('model', 'Annotations') ?></h2>
<?= $form->field($model->asset, 'annotations')->textarea()->label(false) ?>
