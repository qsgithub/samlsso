<?php
namespace quartsoft\samlsso\actions;

use yii\base\Exception;


class SlsAction extends BaseAction
{

    /**
     * After successful logout process user will be redirected to this url.
     */
    public $returnTo;

    /**
     * It handles sls logout request/response from Identity Provider. It will check whether is valid or not. If it isn't, an Exception will be thrown.
     * @throws Exception
     */
    public function run()
    {
        $this->samlSsoComponent->processSLO();

        $errors = $this->samlSsoComponent->getErrors();

        if (!empty($errors)) {
            $message = 'Logout error: ' . implode(",", $errors);
            $reason = $this->samlSsoComponent->getLastErrorReason();
            if (!empty($reason)) {
                $message .= "\n" . $reason;
            }

            throw new Exception($message);
        }

        \Yii::$app->user->logout();

        return \Yii::$app->response->redirect($this->returnTo);
    }
}