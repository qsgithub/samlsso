<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;

class LoginAction extends BaseAction
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