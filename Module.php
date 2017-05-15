<?php

namespace marqu3s\itam;

use Yii;
use yii\helpers\Html;
use yii\base\Module as YiiBaseModule;

/**
 * itam module definition class
 */
class Module extends YiiBaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'marqu3s\itam\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'dashboard/index';

    /**
     * @inheritdoc
     */
    public $layout = 'main';

    /**
     * Set to true to use the RBAC Authorization from Yii 2.
     * This requires the creation of users and the configuration of access rights.
     * @link http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
     *
     * If set to false, (NOT RECOMMENDED) no authorization will be performed and everybody will have permission to use the module.
     * Use at your own risk!
     *
     * @var bool
     */
    public $rbacAuthorization = true; // true is the default and recommended for security reasons!

    /**
     * The prefix used to create and query the permissions.
     * @var string
     */
    public $rbacItemPrefix = 'itam';

    /**
     * The path to the nmap executable
     * @var string
     */
    public $nmapPath = '/usr/local/Cellar/nmap/7.40/bin/';

    /**
     * @var array The default configuration for the action column of the GridViews.
     */
    public static $defaultGridActionColumn = [];




    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->registerTranslations();

        self::$defaultGridActionColumn = [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} &nbsp; {duplicate} &nbsp; {update} &nbsp; {delete}',
            'header' => Module::t('app', 'Actions'),
            'headerOptions' => [
                'style' => 'width: 100px'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-eye"></i>', $url, ['title' => Module::t('app', 'View'), 'data-pjax' => 0]);
                },
                'duplicate' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-copy"></i>', $url, ['title' => Module::t('app', 'Duplicate'), 'data-pjax' => 0]);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-pencil"></i>', $url, ['title' => Module::t('app', 'Update'), 'data-pjax' => 0]);
                },
                'delete' => function ($url, $model, $key) {
                    if (!Yii::$app->getModule('itam')->rbacAuthorization || Yii::$app->user->can(Yii::$app->getModule('itam')->rbacItemPrefix . 'AssetManager')) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, ['title' => Module::t('app', 'Delete'), 'data' => ['pjax' => 0, 'method' => 'post', 'confirm' => Module::t('app', 'Are you sure you want to delete this item?')]]);
                    } else return '';
                },
            ]
        ];
    }

    /**
     * Registers translation files
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/itam/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => __DIR__ . '/messages',
            'fileMap' => [
                'modules/itam/app' => 'app.php',
                'modules/itam/menu' => 'menu.php',
                'modules/itam/model' => 'model.php',
            ],
        ];
    }

    /**
     * Executes the translations.
     *
     * @param string $category
     * @param string $message
     * @param array $params
     * @param string|null $language
     *
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/itam/' . $category, $message, $params, $language);
    }

}
