<?php

namespace marqu3s\itam\controllers;

use yii\web\Controller;

/**
 * Controller for the `itam` module
 */
class DashboardController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
