<?php

namespace app\modules\adminx\controllers;

use app\controllers\MainController;
use app\modules\adminx\components\AccessControl;
use app\modules\adminx\models\Configs;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

class TestController extends MainController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow'      => true,
                    'actions'    => [
                         'index', 'create', 'update', 'delete', 'update-configs', 'php-info'
                    ],
                    'roles'      => ['adminBoss' ],
                ],
            ],
                /*
            'denyCallback' => function ($rule, $action) {
                \yii::$app->getSession()->addFlash("warning",\Yii::t('app', "Действие запрещено"));
                return $this->redirect(\Yii::$app->request->referrer);

        }
        */
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['post'],
            ],

        ];
        return $behaviors;
    }


    public function actionIndex() {
       // $this->layout =  '@app/views/layouts/testLeftMenu.php';
        $m = \Yii::$app->authManager;
        $user_id = \Yii::$app->user->getId();
        $r = $m->userRoles;
        $rr = $m->userRolesPermissions;
        $q = $m->getUserRolesPermissionsFromCahe(3);
        $tt = \Yii::$app->user->can('adminBoss');
     //   $m->getChildrenRolesRecursive('adminBoss', $rr);

        return $this->render('test',[]);
    }



}