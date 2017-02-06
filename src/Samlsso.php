<?php

namespace quartsoft\samlsso;

use yii\base\Component;

class Samlsso extends Component
{

    public $configFile;

    private $instance;
    private $config;

    public function init()
    {
        parent::init();
        $configFile = \Yii::getAlias($this->configFile);
        $this->config = require_once($configFile);
        $this->instance = new \OneLogin_Saml2_Auth($this->config);
        //var_dump($this->instance->signMetadata);die;
    }

    public function login($returnTo = null, $parameters = array(), $forceAuthn = false, $isPassive = false, $stay=false, $setNameIdPolicy = true)
    {
        return $this->instance->login($returnTo, $parameters, $forceAuthn, $isPassive, $stay, $setNameIdPolicy);
    }

    public function logout($returnTo = null, $parameters = array(), $nameId = null, $sessionIndex = null, $stay=false, $nameIdFormat = null)
    {
        return $this->instance->logout($returnTo, $parameters, $nameId, $sessionIndex, $stay, $nameIdFormat);
    }

    public function getMetadata()
    {
        $samlSettings = new \OneLogin_Saml2_Settings($this->config, true);
        $metadata = $samlSettings->getSPMetadata();

        $errors = $samlSettings->validateMetadata($metadata);
        if (!empty($errors)) {
            throw new \Exception('Invalid Metadata Service Provider');
        }

        return $metadata;
    }

    public function getAttributes()
    {
        return $this->instance->getAttributes();
    }

    public function getNameId()
    {
        return $this->instance->getNameId();
    }

    public function getNameIdFormat()
    {
        return $this->instance->getNameIdFormat();
    }

    public function getSessionIndex()
    {
        return $this->instance->getSessionIndex();
    }

    public function getAttribute($name)
    {
        return $this->instance->getAttribute($name);
    }

    public function processResponse($requestId)
    {
        $this->instance->processResponse($requestId);
    }

    public function processSLO($keepLocalSession = false, $requestId = null, $retrieveParametersFromServer = false, $cbDeleteSession = null, $stay=false)
    {
        $this->instance->processSLO($keepLocalSession, $requestId, $retrieveParametersFromServer, $cbDeleteSession, $stay);
    }

    public function getErrors()
    {
        return $this->instance->getErrors();
    }

}

?>