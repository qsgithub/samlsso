<?php

namespace quartsoft\samlsso;

use yii\base\Component;

/**
 * This class wraps OneLogin_Saml2_Auth class by creating an instance of that class using configurations specified in configFile variable inside @common/sampleconfig folder.
 */
class Samlsso extends Component
{

    /**
     * The file in which contains OneLogin_Saml2_Auth configurations.
     */
    public $configFile;

    /**
     * OneLogin_Saml2_Auth instance.
     */
    private $instance;

    /**
     * Configurations for OneLogin_Saml2_Auth.
     */
    private $config;

    public function init()
    {
        parent::init();
        $configFile = \Yii::getAlias($this->configFile);
        $this->config = require_once($configFile);
        $this->instance = new \OneLogin_Saml2_Auth($this->config);
    }

    /**
     * Call the login method on OneLogin_Saml2_Auth.
     */
    public function login($returnTo = null, $parameters = array(), $forceAuthn = false, $isPassive = false, $stay=false, $setNameIdPolicy = true)
    {
        return $this->instance->login($returnTo, $parameters, $forceAuthn, $isPassive, $stay, $setNameIdPolicy);
    }

    /**
     * Call the logout method on OneLogin_Saml2_Auth.
     */
    public function logout($returnTo = null, $parameters = array(), $nameId = null, $sessionIndex = null, $stay=false, $nameIdFormat = null)
    {
        return $this->instance->logout($returnTo, $parameters, $nameId, $sessionIndex, $stay, $nameIdFormat);
    }

    /**
     * Returns the metadata of this Service Provider in xml.
     */
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

    /**
     * Call the getAttributes method on OneLogin_Saml2_Auth.
     */
    public function getAttributes()
    {
        return $this->instance->getAttributes();
    }

    /**
     * Call the getNameId method on OneLogin_Saml2_Auth.
     */
    public function getNameId()
    {
        return $this->instance->getNameId();
    }

    /**
     * Call the getNameIdFormat method on OneLogin_Saml2_Auth.
     */
    public function getNameIdFormat()
    {
        return $this->instance->getNameIdFormat();
    }

    /**
     * Call the getSessionIndex method on OneLogin_Saml2_Auth.
     */
    public function getSessionIndex()
    {
        return $this->instance->getSessionIndex();
    }

    /**
     * Call the getAttribute method on OneLogin_Saml2_Auth.
     */
    public function getAttribute($name)
    {
        return $this->instance->getAttribute($name);
    }

    /**
     * Call the processResponse method on OneLogin_Saml2_Auth.
     */
    public function processResponse($requestId)
    {
        $this->instance->processResponse($requestId);
    }

    /**
     * Call the processSLO method on OneLogin_Saml2_Auth.
     */
    public function processSLO($keepLocalSession = false, $requestId = null, $retrieveParametersFromServer = false, $cbDeleteSession = null, $stay=false)
    {
        $this->instance->processSLO($keepLocalSession, $requestId, $retrieveParametersFromServer, $cbDeleteSession, $stay);
    }

    /**
     * Call the getErrors method on OneLogin_Saml2_Auth.
     */
    public function getErrors()
    {
        return $this->instance->getErrors();
    }

    public function isAuthenticated()
    {
        return $this->instance->isAuthenticated();
    }

}
?>