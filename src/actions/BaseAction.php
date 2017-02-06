<?php

namespace quartsoft\samlsso\actions;

use yii\base\Action;

class BaseAction extends Action
{
    protected $samlSsoComponent;

    public function init()
    {
        parent::init();

        $this->samlSsoComponent = \Yii::$app->samlsso;
    }
}