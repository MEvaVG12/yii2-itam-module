<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 15/04/17
 * Time: 00:00
 */

use marqu3s\itam\Module;

rmrevin\yii\fontawesome\AssetBundle::register($this);

/** @var $this \yii\web\View */
/** @var $content string */

$css = <<<CSS
.nav-pills>li {
    float: none;
}
CSS;
$this->registerCss($css);
?>
<?php $this->beginContent(Yii::$app->viewPath . '/layouts/' . Yii::$app->layout . '.php') ?>
<div class="row">
    <div class="col-md-2">
        <?php echo \yii\bootstrap\Nav::widget([
            'activateParents' => true,
            'items' => [
                [
                    'label' => Module::t('menu', 'Servers'),
                    'url' => ['asset-server/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'label' => Module::t('menu', 'Workstations'),
                    'url' => ['asset-workstation/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'label' => Module::t('menu', 'Locations'),
                    'url' => ['location/index'],
                    //'linkOptions' => ['class' => 'list-group-item'],
                ],
                [
                    'label' => Module::t('menu', 'OSes'),
                    'url' => ['os/index'],
                    //'linkOptions' => [...],
                ],
                [
                    'label' => Module::t('menu', 'Office Suites'),
                    'url' => ['office-suite/index'],
                    //'linkOptions' => [...],
                ],
                /*[
                    'label' => 'Dropdown',
                    'items' => [
                        ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                        '<li class="divider"></li>',
                        '<li class="dropdown-header">Dropdown Header</li>',
                        ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                    ],
                ],*/
                /*[
                    'label' => 'Login',
                    'url' => ['site/login'],
                    'visible' => Yii::$app->user->isGuest
                ],*/
            ],
            'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
        ]);
        ?>
    </div>
    <div class="col-md-10">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent() ?>
