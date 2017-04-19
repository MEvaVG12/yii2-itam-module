<?php

namespace marqu3s\itam;

use Yii;

/**
 * itam module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'marqu3s\itam\controllers';
    public $defaultRoute = 'dashboard/index';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers translation files
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/itam/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/itam/messages',
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
