<?php

namespace app\controllers;

use app\modules\adminx\components\AccessControl;
use app\modules\adminx\models\UControl;
use yii\web\Controller;


class MainController extends Controller
{

  //  public $layout = '@app/views/layouts/commonLayout.php';
    public $layout = '@app/views/layouts/commonLayoutHM.php';
    public $user;
    public $language;

    /**
     * Ответ, который будет возвращаться на AJAX-запросы
     * @var array
     */
    public $result = [
        'status' => false,
        'data' => 'Информация не найдена'
    ];

    public function beforeAction($action)
    {
        $configs = \Yii::$app->configs;
        $this->user = \Yii::$app->user;
        switch (\Yii::$app->configs->menuType){
            case 'horizontal':
                $this->layout =  '@app/views/layouts/commonLayoutHM.php';
                break;
            case 'vertical':
                $this->layout =  '@app/views/layouts/commonLayout.php';
                break;
        }

        $this->getLanguage();

        if (defined('YII_DEBUG') && YII_DEBUG) {
            \Yii::$app->getAssetManager()->forceCopy = true;
        }

        if (\Yii::$app->configs->userControl || \Yii::$app->configs->guestControl){
            $request = \Yii::$app->getRequest();
            $userId = \Yii::$app->user->getId();
            if (!$request->isAjax){
                if (\Yii::$app->configs->userControl){
                    $params = [
                        'user_id' => (!empty($userId)) ? $userId : 0,
                        'remote_ip' => $request->getRemoteIP() ,
                        'referrer' => $request->getReferrer() ,
                        'remote_host' => $request->getRemoteHost(),
                        'absolute_url' => $request->getAbsoluteUrl() ,
                        'url' => $request->getUrl() ,
                        'created_at' => time(),
                    ];
                    $ret = UControl::guestControl($params);
                }
                if (\Yii::$app->configs->guestControl){
                    if (!empty($userId)){
                        $ret = UControl::userControl($userId,$request->getUrl() );
                    }
                }


            }
        }



        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function getLanguage()
    {
        $this->language = 'en-US';
        $lang = \Yii::$app->conservation->language;
        if (empty($lang)){
            $session = \Yii::$app->session;
            $lang = $session->get('language');
            if (empty($lang)){
                $lang = \Yii::$app->language;
            }
        }
        $this->language = $lang;
        \Yii::$app->language = $lang;
        return true;
    }


    /**
     * This method forms array of common actions.
     * 
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

}