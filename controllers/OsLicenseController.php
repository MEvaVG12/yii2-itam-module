<?php

namespace marqu3s\itam\controllers;

use Yii;
use marqu3s\itam\Module;
use marqu3s\itam\models\OsLicense;
use marqu3s\itam\models\OsLicenseSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OsLicenseController implements the CRUD actions for OsLicense model.
 */
class OsLicenseController extends Controller
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
                            'roles' => [$this->module->rbacItemPrefix . 'LicenseManager']
                        ],
                    ],
                ],
            ]);
        }

        return $config;
    }

    /**
     * Lists all OsLicenses models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OsLicenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new OsLicense model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OsLicense();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', 'OsLicense') . ' ' . Module::t('app', 'created successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OsLicense model.
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
            Yii::$app->session->setFlash('success', Module::t('app', 'OsLicense') . ' ' . Module::t('app', 'updated successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OsLicense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Module::t('app', 'OsLicense') . ' ' . Module::t('app', 'deleted successfully.'));

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
     * Finds the OsLicense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return OsLicense the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OsLicense::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
