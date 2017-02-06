<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;

class LoginAction extends BaseAction
{
    public $returnTo;

    public function run()
    {

        $this->samlSsoComponent->login($this->returnTo);
    }
}