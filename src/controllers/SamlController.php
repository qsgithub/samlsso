<?php

namespace quartsoft\samlsso\controllers;

use quartsoft\samlsso\actions\AcsAction;
use quartsoft\samlsso\actions\LoginAction;
use quartsoft\samlsso\actions\LogoutAction;
use quartsoft\samlsso\actions\MetadataAction;
use quartsoft\samlsso\actions\SlsAction;
use yii\helpers\Url;
use yii\web\Controller;

class SamlController extends Controller
{
    /**
     * Actions which used for working with onelogin/php-saml
     */
    public function actions() {
        return [
            'loginsaml' => [
                'class' => LoginAction::className(),
                'returnTo' => Url::to('site/index')
            ],
            'logoutsaml' => [
                'class' => LogoutAction::className(),
                'returnTo' => Url::to('site/index'),
            ],
            'acs' => [
                'class' => AcsAction::className(),
                'returnTo' => Url::to('site/index'),
            ],
            'sls' => [
                'class' => SlsAction::className(),
            ],
            'metadata' => [
                'class' => MetadataAction::className(),
            ]
        ];
    }

    /**
     * Replace login for onelogin saml
     */
    public function beforeAction($action) {
        if ($action->id == 'login') {
            $this->redirect(['loginsaml']);
        }
        return parent::beforeAction($action);
    }
}