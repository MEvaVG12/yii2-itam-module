<?php

namespace marqu3s\itam\controllers;

use Yii;
use yii\rbac\ManagerInterface;
use yii\rbac\Role;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AuthorizationController implements the CRUD actions for Authorization rules.
 */
class AuthorizationController extends Controller
{
    /** @var ManagerInterface */
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
     * Creates the basic authorization rules.
     *
     * @return mixed
     */
    public function actionCreateRules()
    {
        if (Yii::$app->request->isPost) {
            $trans = Yii::$app->db->beginTransaction();
            try {
                $this->eraseRules();
                $this->auth = Yii::$app->authManager;
                $this->adminRole = $this->createAdminRole();
                $this->createAssetRoles();
                $this->createSoftwareRoles();
                $this->createReportsRoles();

                # Assign admin role to the admin user
                $this->auth->assign($this->adminRole, 1);

                # All done
                $trans->commit();

                Yii::$app->session->setFlash('success', 'Rules created successfully.');
                $this->refresh();
            } catch (\Exception $e) {
                $trans->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('createRules', [
            'prefix' => $this->module->rbacItemPrefix
        ]);
    }


    private function createAssetRoles()
    {
        # Add "createAsset" permission
        $createAsset = $this->auth->createPermission($this->module->rbacItemPrefix . 'CreateAsset');
        $createAsset->description = 'Create an asset';
        $this->auth->add($createAsset);

        # Add "updateAsset" permission
        $updateAsset = $this->auth->createPermission($this->module->rbacItemPrefix . 'UpdateAsset');
        $updateAsset->description = 'Update an asset';
        $this->auth->add($updateAsset);

        # Add "deleteAsset" permission
        $deleteAsset = $this->auth->createPermission($this->module->rbacItemPrefix . 'DeleteAsset');
        $deleteAsset->description = 'Delete an asset';
        $this->auth->add($deleteAsset);

        # Add "assetManager" role and give all the roles to it.
        $assetManager = $this->auth->createRole($this->module->rbacItemPrefix . 'AssetManager');
        $assetManager->description = 'Asset manager';
        $this->auth->add($assetManager);
        $this->auth->addChild($assetManager, $createAsset);
        $this->auth->addChild($assetManager, $updateAsset);
        $this->auth->addChild($assetManager, $deleteAsset);

        # Add "assetCreator" role and give "createAsset" and "updateAsset" roles to it.
        $assetCreator = $this->auth->createRole($this->module->rbacItemPrefix . 'AssetCreator');
        $assetCreator->description = 'Asset creator';
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
        $createSoftware->description = 'Create a software';
        $this->auth->add($createSoftware);

        # Add "updateSoftware" permission
        $updateSoftware = $this->auth->createPermission($this->module->rbacItemPrefix . 'UpdateSoftware');
        $updateSoftware->description = 'Update a software';
        $this->auth->add($updateSoftware);

        # Add "deleteSoftware" permission
        $deleteSoftware = $this->auth->createPermission($this->module->rbacItemPrefix . 'DeleteSoftware');
        $deleteSoftware->description = 'Delete a software';
        $this->auth->add($deleteSoftware);

        # Add "softwareManager" role and give all the roles to it.
        $softwareManager = $this->auth->createRole($this->module->rbacItemPrefix . 'SoftwareManager');
        $softwareManager->description = 'Software manager';
        $this->auth->add($softwareManager);
        $this->auth->addChild($softwareManager, $createSoftware);
        $this->auth->addChild($softwareManager, $updateSoftware);
        $this->auth->addChild($softwareManager, $deleteSoftware);



        # Add "createLicense" permission
        $createLicense = $this->auth->createPermission($this->module->rbacItemPrefix . 'CreateLicense');
        $createLicense->description = 'Create a software license';
        $this->auth->add($createLicense);

        # Add "updateLicense" permission
        $updateLicense = $this->auth->createPermission($this->module->rbacItemPrefix . 'UpdateLicense');
        $updateLicense->description = 'Update a software license';
        $this->auth->add($updateLicense);

        # Add "deleteLicense" permission
        $deleteLicense = $this->auth->createPermission($this->module->rbacItemPrefix . 'DeleteLicense');
        $deleteLicense->description = 'Delete a software license';
        $this->auth->add($deleteLicense);

        # Add "licenseManager" role and give all the roles to it.
        $licenseManager = $this->auth->createRole($this->module->rbacItemPrefix . 'LicenseManager');
        $licenseManager->description = 'License manager';
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
        $accessReports->description = 'View reports';
        $this->auth->add($accessReports);

        # add "ViewReports" role to the "admin" role.
        $this->auth->addChild($this->adminRole, $accessReports);
    }

    private function createAdminRole()
    {
        $admin = $this->auth->createRole($this->module->rbacItemPrefix . 'Admin');
        $admin->description = 'System Administrator';
        $this->auth->add($admin);

        return $admin;
    }

    private function eraseRules()
    {
        $sql = "DELETE FROM auth_assignment WHERE item_name LIKE '" . $this->module->rbacItemPrefix . "%'";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "DELETE FROM auth_item WHERE name LIKE '" . $this->module->rbacItemPrefix . "%'";
        Yii::$app->db->createCommand($sql)->execute();

        $sql = "DELETE FROM auth_rule WHERE name LIKE '" . $this->module->rbacItemPrefix . "%'";
        Yii::$app->db->createCommand($sql)->execute();
    }

}
