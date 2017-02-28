<?php

namespace quartsoft\samlsso;

use yii\base\Component;

/**
 * This class wraps OneLogin_Saml2_Auth class by creating an instance of that class using configurations specified in configFile variable inside @common/config folder.
 */
class Samlsso extends Component
{

    /**
     * The file in which contains OneLogin_Saml2_Auth configurations.
     */
    public $configFile;

    /**
     * @var \OneLogin_Saml2_Auth
     */
    private $instance;

    /**
     * @var array
     * Configurations for OneLogin_Saml2_Auth.
     */
    private $config;

    private $_attributes = [];

    public function init()
    {
        parent::init();
        $configFile = \Yii::getAlias($this->configFile);

        $this->config = require($configFile);
        $this->instance = new \OneLogin_Saml2_Auth($this->config);
    }

    /**
     * Call the login method on OneLogin_Saml2_Auth.
     *
     * @param null $returnTo
     * @param array $parameters
     * @param bool $forceAuth
     * @param bool $isPassive
     * @param bool $stay
     * @param bool $setNameIdPolicy
     * @return string
     */
    public function login($returnTo = null, $parameters = array(), $forceAuth = false, $isPassive = false, $stay=false, $setNameIdPolicy = false)
    {
        return $this->instance->login($returnTo, $parameters, $forceAuth, $isPassive, $stay, $setNameIdPolicy);
    }

    /**
     * Call the logout method on OneLogin_Saml2_Auth.
     *
     * @param null $returnTo
     * @param array $parameters
     * @return string
     */
    public function logout($returnTo = null, $parameters = array())
    {
        $sessionIndex = $this->getSession()->get('samlUserData')['session_index'];
        $nameId = $this->getSession()->get('samlNameId');
        return $this->instance->logout($returnTo, $parameters, $nameId, $sessionIndex, false);
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
        $map = $this->config['attributeMap'];
        $attributes = $this->instance->getAttributes();
        foreach ($attributes as $name => $value) {
            if (isset($map[$name])) {
                $this->_attributes[$map[$name]] = $value[0];
            }

            if ($map[$name] == 'email') {
                $parts = explode("@", $value[0]);
                $this->_attributes['username'] = $parts[0];
            }
        }
        $this->_attributes['session_index'] = $this->instance->getSessionIndex();
        return $this->_attributes;
    }


    /**
     * Set session values
     */
    public function setSession()
    {
        $session = \Yii::$app->session;
        $session->set('samlUserData', $this->getAttributes());
        $session->set('samlNameId', $this->getNameId());
        $session->set('samlNameIdFormat', $this->getNameIdFormat());
        $session->set('samlSessionIndex', $this->getSessionIndex());
        $session->remove('AuthNRequestID');
    }


    /**
     * @return mixed|\yii\web\Session
     */
    public function getSession()
    {
        return \Yii::$app->session;

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
     *
     * @param $name
     * @return array|null
     */
    public function getAttribute($name)
    {
        return $this->instance->getAttribute($name);
    }

    /**
     * Call the processResponse method on OneLogin_Saml2_Auth.
     *
     * @param $requestId
     */
    public function processResponse($requestId)
    {
        $this->instance->processResponse($requestId);
    }

    /**
     * Call the processSLO method on OneLogin_Saml2_Auth.
     *
     * @param bool $keepLocalSession
     * @param null $requestId
     * @param bool $retrieveParametersFromServer
     * @param null $cbDeleteSession
     * @param bool $stay
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
    
    /**
     * Call the getLastErrorReason method on OneLogin_Saml2_Auth.
     */
    public function getLastErrorReason()
    {
	    return $this->instance->getLastErrorReason();
    }
    
    public function isAuthenticated()
    {
	    return $this->instance->isAuthenticated();
    }
}
?>