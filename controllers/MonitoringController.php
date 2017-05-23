<?php

namespace marqu3s\itam\controllers;

use marqu3s\itam\models\Config;
use Yii;
use marqu3s\itam\Module;
use marqu3s\itam\models\Monitoring;
use marqu3s\itam\models\MonitoringSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MonitoringController implements the CRUD actions for Monitoring model.
 */
class MonitoringController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $config = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ]
        ];

        if ($this->module->rbacAuthorization) {
            $config = array_merge($config, [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => [$this->module->rbacItemPrefix . 'Admin']
                        ],
                    ],
                ],
            ]);
        }

        return $config;
    }

    /**
     * Lists all Location models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MonitoringSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $config = Config::findOne(1);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'config' => $config,
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Monitoring();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', 'Monitor') . ' ' . Module::t('app', 'created successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', 'Monitor') . ' ' . Module::t('app', 'updated successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Module::t('app', 'Monitor') . ' ' . Module::t('app', 'deleted successfully.'));

        return $this->redirect(['index']);
    }

    /**
     * Show an existing model.
     *
     * @param integer $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Monitoring the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Monitoring::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
