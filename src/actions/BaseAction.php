<?php

namespace quartsoft\samlsso\actions;

use yii\base\Action;

/**
 * Base class for actions.
 */
class BaseAction extends Action
{
    /**
     * This variable should be the component name of quartsoft\samlsso\Samlsso.
     * @var string
     */
    public $samlSsoInstanceName = 'samlsso';

    /**
     * This variable hold the instance of quartsoft\samlsso\Samlsso.
     */
    protected $samlSsoComponent;


    public function init()
    {
        parent::init();

        $this->samlSsoComponent = \Yii::$app->get($this->samlSsoInstanceName);
    }
}