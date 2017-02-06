<?php

namespace quartsoft\samlsso\controllers;

use yii\helpers\Url;
use yii\web\Controller;

class SamlController extends Controller
{
    public function actions() {
        return [
            'loginsaml' => [
                'class' => 'quartsoft\samlsso\actions\LoginAction',
                'returnTo' => Url::to('site/index')
            ],
            'logoutsaml' => [
                'class' => 'quartsoft\samlsso\actions\LogoutAction',
                'returnTo' => Url::to('site/index'),
            ],
            'acs' => [
                'class' => 'quartsoft\samlsso\actions\AcsAction',
                'returnTo' => Url::to('site/index'),
            ],
            'sls' => [
                'class' => 'quartsoft\samlsso\actions\SlsAction',
            ],
            'metadata' => [
                'class' => 'quartsoft\samlsso\actions\MetadataAction'
            ]
        ];
    }

    public function beforeAction($action) {
        if ($action->id == 'login') {
            $this->redirect(['loginsaml']);
        }
        return parent::beforeAction($action);
    }
}