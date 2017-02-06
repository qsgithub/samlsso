<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;

class LogoutAction extends BaseAction
{
    /**
     * @var string An url which user will be redirected to after logout.
     */
    public $returnTo;

    /**
     * Initiates Logout.
     */
    public function run()
    {
        $this->samlSsoComponent->logout($this->returnTo);
    }
}