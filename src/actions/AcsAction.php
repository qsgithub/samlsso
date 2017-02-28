<?php
namespace quartsoft\samlsso\actions;

use common\models\User as User;
use yii\base\Exception;

class AcsAction extends BaseAction
{

    /**
     * After successful login process user will be redirected to this url.
     */
    public $returnTo;

    /**
     * It handles acs response from Identity Provider. It will check whether the response is valid or not. If it isn't, an Exception will be thrown. If the response is valid, the successCallback will be called. After that, user will be redirected to returnTo.
     * @throws Exception
     */
    public function run()
    {
        \Yii::$app->session->open();
        $authNRequestId = \Yii::$app->session->get('AuthNRequestID');

        if(isset($authNRequestId)) {
            $requestId = $_SESSION['AuthNRequestID'];
        } else {
            $requestId = null;
        }

        $this->samlSsoComponent->processResponse($requestId);

        $errors = $this->samlSsoComponent->getErrors();
        if (!empty($errors)) {
            $message = 'Saml error response: ' .implode(",", $errors);
            $reason = $this->samlSsoComponent->getLastErrorReason();
            if (!empty($reason)) {
                $message .= "\n".$reason;
            }
            throw new Exception($message);
        }


        if ($this->samlSsoComponent->isAuthenticated()) {
            $this->loginUser();
        }

        return \Yii::$app->response->redirect($this->returnTo);
    }

    /**
     * Login|SignUp User based on received attributes
     */
    protected function loginUser()
    {
        $attributes = $this->samlSsoComponent->getAttributes();

        if (!$user = User::findByUsername($attributes['username'])) {
            $user->setAttributes($attributes, false);
            $password = \Yii::$app->getSecurity()->generatePasswordHash($attributes['session_index']);
            $user->setPassword($password);
            $user->save();
        }
        \Yii::$app->user->login($user);

        $this->samlSsoComponent->setSession();
    }
}