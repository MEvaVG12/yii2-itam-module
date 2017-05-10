<?php

namespace marqu3s\itam\controllers;

use Yii;
use marqu3s\itam\Module;
use marqu3s\itam\models\OfficeSuiteLicense;
use marqu3s\itam\models\OfficeSuiteLicenseSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfficeSuiteLicenseController implements the CRUD actions for OfficeSuiteLicense model.
 */
class OfficeSuiteLicenseController extends Controller
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
     * Lists all OfficeSuiteLicenses models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OfficeSuiteLicenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new OfficeSuiteLicense model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OfficeSuiteLicense();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', 'OfficeSuiteLicense') . ' ' . Module::t('app', 'created successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OfficeSuiteLicense model.
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
            Yii::$app->session->setFlash('success', Module::t('app', 'OfficeSuiteLicense') . ' ' . Module::t('app', 'updated successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OfficeSuiteLicense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Module::t('app', 'OfficeSuiteLicense') . ' ' . Module::t('app', 'deleted successfully.'));

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
     * Finds the OfficeSuiteLicense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return OfficeSuiteLicense the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OfficeSuiteLicense::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
