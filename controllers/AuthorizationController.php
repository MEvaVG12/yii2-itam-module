<?php

namespace marqu3s\itam\controllers;

use Yii;
use yii\rbac\DbManager;
use yii\rbac\Role;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AuthorizationController implements the CRUD actions for Authorization rules.
 */
class AuthorizationController extends Controller
{
    /** @var DbManager */
    private $auth;

    /** @var Role */
    private $adminRole;


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
     * Index page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'prefix' => $this->module->rbacItemPrefix
        ]);
    }

    /**
     * Creates the basic authorization rules.
     *
     * @return mixed
     */
    public function actionCreateRules()
    {
        if (Yii::$app->request->isPost) {
            $trans = Yii::$app->db->beginTransaction();
            try {
                $this->auth = Yii::$app->authManager;
                $this->eraseRules();
                $this->adminRole = $this->createAdminRole();
                $this->createAssetRoles();
                $this->createSoftwareRoles();
                $this->createReportsRoles();

                # All done
                $trans->commit();

                Yii::$app->session->setFlash('success', 'Rules created successfully.');
            } catch (\Exception $e) {
                $trans->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'prefix' => $this->module->rbacItemPrefix
        ]);
    }

    /**
     * Assign a user ID to the admin role.
     *
     * @return \yii\web\Response
     */
    public function actionAssignAdmin()
    {
        if (Yii::$app->request->isPost) {
            # Get the admin role
            $this->auth = Yii::$app->authManager;
            $this->adminRole = $this->auth->getRole($this->module->rbacItemPrefix . 'Admin');

            # Assign admin role to the admin user
            $this->auth->assign($this->adminRole, (int)Yii::$app->request->post('user_id', 1));

            Yii::$app->session->setFlash('success', 'Admin assigned successfully.');
        }

        return $this->redirect(['index']);
    }


    private function createAssetRoles()
    {
        # Add "createAsset" permission
        $createAsset = $this->auth->createPermission($this->module->rbacItemPrefix . 'CreateAsset');
        $createAsset->description = '[ITAM] Create an asset';
        $this->auth->add($createAsset);

        # Add "updateAsset" permission
        $updateAsset = $this->auth->createPermission($this->module->rbacItemPrefix . 'UpdateAsset');
        $updateAsset->description = '[ITAM] Update an asset';
        $this->auth->add($updateAsset);

        # Add "deleteAsset" permission
        $deleteAsset = $this->auth->createPermission($this->module->rbacItemPrefix . 'DeleteAsset');
        $deleteAsset->description = '[ITAM] Delete an asset';
        $this->auth->add($deleteAsset);

        # Add "assetManager" role and give all the roles to it.
        $assetManager = $this->auth->createRole($this->module->rbacItemPrefix . 'AssetManager');
        $assetManager->description = '[ITAM] Asset manager';
        $this->auth->add($assetManager);
        $this->auth->addChild($assetManager, $createAsset);
        $this->auth->addChild($assetManager, $updateAsset);
        $this->auth->addChild($assetManager, $deleteAsset);

        # Add "assetCreator" role and give "createAsset" and "updateAsset" roles to it.
        $assetCreator = $this->auth->createRole($this->module->rbacItemPrefix . 'AssetCreator');
        $assetCreator->description = '[ITAM] Asset creator';
        $this->auth->add($assetCreator);
        $this->auth->addChild($assetCreator, $createAsset);
        $this->auth->addChild($assetCreator, $updateAsset);

        # add "assetManager" role to the "admin" role.
        $this->auth->addChild($this->adminRole, $assetManager);
    }

    private function createSoftwareRoles()
    {
        # Add "createSoftware" permission
        $createSoftware = $this->auth->createPermission($this->module->rbacItemPrefix . 'CreateSoftware');
        $createSoftware->description = '[ITAM] Create a software';
        $this->auth->add($createSoftware);

        # Add "updateSoftware" permission
        $updateSoftware = $this->auth->createPermission($this->module->rbacItemPrefix . 'UpdateSoftware');
        $updateSoftware->description = '[ITAM] Update a software';
        $this->auth->add($updateSoftware);

        # Add "deleteSoftware" permission
        $deleteSoftware = $this->auth->createPermission($this->module->rbacItemPrefix . 'DeleteSoftware');
        $deleteSoftware->description = '[ITAM] Delete a software';
        $this->auth->add($deleteSoftware);

        # Add "softwareManager" role and give all the roles to it.
        $softwareManager = $this->auth->createRole($this->module->rbacItemPrefix . 'SoftwareManager');
        $softwareManager->description = '[ITAM] Software manager';
        $this->auth->add($softwareManager);
        $this->auth->addChild($softwareManager, $createSoftware);
        $this->auth->addChild($softwareManager, $updateSoftware);
        $this->auth->addChild($softwareManager, $deleteSoftware);



        # Add "createLicense" permission
        $createLicense = $this->auth->createPermission($this->module->rbacItemPrefix . 'CreateLicense');
        $createLicense->description = '[ITAM] Create a software license';
        $this->auth->add($createLicense);

        # Add "updateLicense" permission
        $updateLicense = $this->auth->createPermission($this->module->rbacItemPrefix . 'UpdateLicense');
        $updateLicense->description = '[ITAM] Update a software license';
        $this->auth->add($updateLicense);

        # Add "deleteLicense" permission
        $deleteLicense = $this->auth->createPermission($this->module->rbacItemPrefix . 'DeleteLicense');
        $deleteLicense->description = '[ITAM] Delete a software license';
        $this->auth->add($deleteLicense);

        # Add "licenseManager" role and give all the roles to it.
        $licenseManager = $this->auth->createRole($this->module->rbacItemPrefix . 'LicenseManager');
        $licenseManager->description = '[ITAM] License manager';
        $this->auth->add($licenseManager);
        $this->auth->addChild($licenseManager, $createLicense);
        $this->auth->addChild($licenseManager, $updateLicense);
        $this->auth->addChild($licenseManager, $deleteLicense);



        # Add "softwareManager" role to "licenseManager".
        $this->auth->addChild($licenseManager, $softwareManager);

        # add "softwareManager" and "licenseManager" roles to the "admin" role.
        $this->auth->addChild($this->adminRole, $softwareManager);
        $this->auth->addChild($this->adminRole, $licenseManager);
    }

    private function createReportsRoles()
    {
        # Add "ViewReports" permission
        $accessReports = $this->auth->createPermission($this->module->rbacItemPrefix . 'ViewReports');
        $accessReports->description = '[ITAM] View reports';
        $this->auth->add($accessReports);

        # add "ViewReports" role to the "admin" role.
        $this->auth->addChild($this->adminRole, $accessReports);

        # add "ViewReports" role to the "LicenseManager" role.
        $licenseManagerRole = $this->auth->getRole($this->module->rbacItemPrefix . 'LicenseManager');
        $this->auth->addChild($licenseManagerRole, $accessReports);
    }

    private function createAdminRole()
    {
        $admin = $this->auth->createRole($this->module->rbacItemPrefix . 'Admin');
        $admin->description = '[ITAM] System Administrator';
        $this->auth->add($admin);

        return $admin;
    }

    private function eraseRules()
    {
        $sql = "DELETE FROM {$this->auth->assignmentTable} WHERE item_name LIKE '" . $this->module->rbacItemPrefix . "%'";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "DELETE FROM {$this->auth->itemTable} WHERE name LIKE '" . $this->module->rbacItemPrefix . "%'";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "DELETE FROM {$this->auth->ruleTable} WHERE name LIKE '" . $this->module->rbacItemPrefix . "%'";
        Yii::$app->db->createCommand($sql)->execute();
    }
}
