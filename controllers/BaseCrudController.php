<?php
/**
 * Created by PhpStorm.
 * User: joao
 * Date: 21/04/17
 * Time: 01:55
 */

namespace marqu3s\itam\controllers;

use marqu3s\itam\Module;
use marqu3s\itam\models\AssetForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class BaseCrudController is a base CRUD controller.
 * Controllers that defines CRUD operations for assets must extend this BaseController
 * and define the values of the protected attributes.
 *
 * @package marqu3s\itam\controllers
 */
abstract class BaseCrudController extends Controller
{
    protected $assetType;
    protected $modelClass;
    protected $modelForm;
    protected $searchClass;

    protected $gridDataColumns = [];
    private   $gridActionColumn = [];


    /**
     * BaseCrudController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        if (empty($this->assetType)) {
            throw new InvalidConfigException('assetType must be defined in the BaseCrudController child class.');
        }

        if (empty($this->modelClass)) {
            throw new InvalidConfigException('modelClass must be defined in the BaseCrudController child class.');
        }

        if (empty($this->modelForm)) {
            throw new InvalidConfigException('modelForm must be defined in the BaseCrudController child class.');
        }

        if (empty($this->searchClass)) {
            throw new InvalidConfigException('searchClass must be defined in the BaseCrudController child class.');
        }

        $this->gridActionColumn = [[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} &nbsp; {delete}',
            'header' => Module::t('app', 'Actions'),
            'headerOptions' => [
                'style' => 'width: 70px'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-pencil"></i>', $url, ['title' => Module::t('app', 'Update'), 'data-pjax' => 0]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-trash"></i>', $url, ['title' => Module::t('app', 'Delete'), 'data' => ['pjax' => 0, 'method' => 'post', 'confirm' => Module::t('app', 'Are you sure you want to delete this item?')]]);
                },
            ]
        ]];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var ActiveRecord $searchModel */
        $searchModel = new $this->searchClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gridColumns' => array_merge($this->gridDataColumns, $this->gridActionColumn)
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
        /** @var AssetForm $form */
        $form = new $this->modelForm();
        $form->setAttributes(Yii::$app->request->post());

        if (Yii::$app->request->post() && $form->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', $this->getShortModelName($this->modelClass)) . ' ' . Module::t('app', 'created successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $form,
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
        /** @var AssetForm $form */
        $form = new $this->modelForm();
        $form->{$this->assetType} = $this->findModel($id);
        $form->setAttributes(Yii::$app->request->post());

        if (Yii::$app->request->post() && $form->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', $this->getShortModelName($this->modelClass)) . ' ' . Module::t('app', 'updated successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $form,
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
        Yii::$app->session->setFlash('success', Module::t('app', $this->getShortModelName($this->modelClass)) . ' ' . Module::t('app', 'deleted successfully.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Returns a Class name without namespace
     *
     * @param string $class a class name with namespace. For example: marqu3s\models\Asset
     *
     * @return string
     */
    private function getShortModelName($class)
    {
        $tmp = array_reverse(explode("\\", $class));

        return $tmp[0];
    }
}
