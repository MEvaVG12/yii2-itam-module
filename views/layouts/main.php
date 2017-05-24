<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 15/04/17
 * Time: 00:00
 */

use marqu3s\itam\Module;

rmrevin\yii\fontawesome\AssetBundle::register($this);
marqu3s\itam\assets\ModuleAsset::register($this);

/** @var $this \yii\web\View */
/** @var $content string */

include('_menuItems.php');
?>
<?php $this->beginContent(Yii::$app->viewPath . '/layouts/' . Yii::$app->layout . '.php') ?>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
    <h3>MENU</h3>
    <?php echo \yii\bootstrap\Nav::widget([
        'activateParents' => true,
        'items' => $items,
        'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
    ]);
    ?>
</nav>
<div id="itamModule" class="itam-module">
    <div class="row">
        <div class="col-xs-12">
            <!-- uncomment to show the menu on the right, slide over style -->
            <!--<div id="showMenuLeft" class="text-center">
                <i class="fa fa-bars fa-2x"></i><br>
                <small>MENU</small>
            </div>-->
            <div id="showMenuRight" class="text-center">
                <i class="fa fa-bars fa-2x"></i><br>
                <small>MENU</small>
            </div>
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent() ?>
