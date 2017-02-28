<?php

namespace quartsoft\samlsso\Actions;

use yii\base\Action;

/**
 * Base class for actions.
 */
class BaseAction extends Action
{
    /**
     * This variable should be the component name of quartsoft\samlsso\samlsso.
     * @var string
     */
    public $samlSsoInstanceName = 'samlsso';

    /**
     * This variable hold the instance of quartsoft\samlsso\samlsso.
     * @var \quartsoft\samlsso\samlsso
     */
    protected $samlSsoComponent;


    public function init()
    {
        parent::init();

        $this->samlSsoComponent = \Yii::$app->get($this->samlSsoInstanceName);
        \Yii::$app->controller->enableCsrfValidation = false;
    }
}