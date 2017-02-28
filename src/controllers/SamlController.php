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
     * Actions which used for working with Saml flow
     */
    public function actions() {
        return [
            'loginsaml' => [
                'class' => LoginAction::className(),
                'returnTo' => Url::to('site/index')
            ],
            'logoutsaml' => [
                'class' => LogoutAction::className(),
            ],
            'acs' => [
                'class' => AcsAction::className(),
                'returnTo' => Url::to('site/index'),
            ],
            'sls' => [
                'class' => SlsAction::className(),
                'returnTo' => Url::to('site/index'),
            ],
            'metadata' => [
                'class' => MetadataAction::className(),
            ]
        ];
    }

    /**
     * Redirect default login and logout requests
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action) {
        switch ($action->id) {
            case 'login':
                $this->redirect(['loginsaml']);
                break;
            case 'logout':
                $this->redirect(['logoutsaml']);
                break;
        }
        return parent::beforeAction($action);
    }
}