<?php
namespace quartsoft\samlsso\actions;

class LogoutAction extends BaseAction
{
    /**
     * @var string An url which user will be redirected to after logout.
     */
    public $returnTo;

    /**
     * Initiate logout process using Saml.
     */
    public function run()
    {
        $this->samlSsoComponent->logout($this->returnTo);
    }

}