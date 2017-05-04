<?php

namespace marqu3s\itam\controllers;

use Yii;
use marqu3s\itam\Module;
use marqu3s\itam\models\User;
use marqu3s\itam\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [$this->module->rbacItemPrefix . 'Admin']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Module::t('app', 'User') . ' ' . Module::t('app', 'created successfully.'));
            return $this->redirect(['index']);
        } else {
            \yii\helpers\VarDumper::dump($model->errors, 10, true);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
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
            Yii::$app->session->setFlash('success', Module::t('app', 'User') . ' ' . Module::t('app', 'updated successfully.'));
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Location model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Module::t('app', 'User') . ' ' . Module::t('app', 'deleted successfully.'));

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
     * Manages the users permissions.
     *
     * @param null $idUser
     *
     * @return string
     */
    public function actionPermissions($idUser = null)
    {
        $idUser = (int) $idUser;
        $auth = Yii::$app->authManager;

        if (Yii::$app->request->isPost) {
            # Revoke all the user permissions.
            $auth->revokeAll($idUser);

            if (count(Yii::$app->request->post('roles'))) {
                # Add the selected roles
                foreach (Yii::$app->request->post('roles') as $roleId) {
                    $role = $auth->getRole($roleId);
                    $auth->assign($role, $idUser);
                }
            }

            Yii::$app->session->setFlash('success', 'User permissions updated.');
        }
        
        return $this->render('permissions', [
            'users' => User::find()->orderBy(['name' => SORT_ASC])->all(),
            'user' => User::findOne($idUser),
            'userRoles' => $auth->getRolesByUser($idUser),
            'availableRoles' => $auth->getRoles(),
        ]);
    }


    /**
     * Finds the Location model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
