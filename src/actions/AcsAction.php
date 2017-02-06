<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;
use yii\base\Exception;

class AcsAction extends BaseAction
{
    public $returnTo;

    public function run()
    {
        \Yii::$app->session->open();
        $authNRequestID = \Yii::$app->session->get('AuthNRequestID');

        if(isset($authNRequestID)) {
            $requestID = $_SESSION['AuthNRequestID'];
        } else {
            $requestID = null;
        }
        $this->samlSsoComponent->processResponse($requestID);
        $errors = $this->samlSsoComponent->getErrors();
        if (!empty($errors)) {
            $message = 'Saml error response: ' .implode(",", $errors);
            throw new Exception($message);
        }
        $this->setSession();
        return \Yii::$app->response->redirect($this->returnTo);

    }

    public function setSession()
    {
        $session = \Yii::$app->session;
        $session->set('samlUserdata', $this->samlSsoComponent->getAttributes());
        $session->set('samlNameId', $this->samlSsoComponent->getNameId());
        $session->set('samlNameIdFormat', $this->samlSsoComponent->getNameIdFormat());
        $session->set('samlSessionIndex', $this->samlSsoComponent->getSessionIndex());
        $session->remove('AuthNRequestID');
    }
}