<?php
namespace quartsoft\samlsso\actions;

use \quartsoft\samlsso\actions\BaseAction as SamlBaseAction;

class LoginAction extends SamlBaseAction
{
    /**
     * @var string An url which user will be redirected to after login.
     */
    public $returnTo;

    /**
     * Initiate login process using Saml.
     */
    public function run()
    {
        $this->samlSsoComponent->login($this->returnTo);
    }
}