<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;
use yii\base\Exception;

class AcsAction extends BaseAction
{

    /**
     * After succesfull login process user will be redirected to this url.
     */
    public $returnTo;

    /**
     * It handles acs response from Identity Provider. It will check whether the response is valid or not. If it isn't, an Exception will be thrown. If the response is valid, the successCallback will be called. After that, user will be redirected to returnTo.
     * @throws Exception
     */
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
        if ($this->samlSsoComponent->isAuthenticated()) {
            $attributes = $this->samlSsoComponent->getAttributes();

            if (!$user = User::findByUsername($attributes['username'])) {
                $user->setAttributes($attributes, false);
                $password = \Yii::$app->getSecurity()->generatePasswordHash($attributes['session_index']);
                $user->setPassword($password);
                $user->save();
            }
            \Yii::$app->user->login($user);

            $this->setSession();
        }

        return \Yii::$app->response->redirect($this->returnTo);

    }

    /**
     * Set session value
     */
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