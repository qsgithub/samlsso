<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;

class LogoutAction extends BaseAction
{
    public $returnTo;

    public function run()
    {
        $this->samlSsoComponent->logout($this->returnTo);
    }
}