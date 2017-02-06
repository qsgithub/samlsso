<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;
use yii\base\Exception;


class SlsAction extends BaseAction
{

    /**
     * It handles sls logout request/response from Identity Provider. It will check whether is valid or not. If it isn't, an Exception will be thrown.
     * @throws Exception
     */
    public function run()
    {
        $LogoutRequestID = \Yii::$app->session->get('LogoutRequestID');

        if(isset($LogoutRequestID)) {
            $requestID = $_SESSION['LogoutRequestID'];
        } else {
            $requestID = null;
        }
        $this->samlSsoComponent->processSLO(false, $requestID);;
        $errors = $this->samlSsoComponent->getErrors();
        if (!empty($errors)) {
            $message = 'Logout errors: ' .implode(",", $errors);
            throw new Exception($message);
        } else {
            echo '<p>Sucessfully logged out</p>';
            \Yii::$app->session->destroy();
        }
    }
}