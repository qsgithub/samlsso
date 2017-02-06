<?php
namespace quartsoft\samlsso\actions;

use quartsoft\samlsso\actions\BaseAction;
use yii\web\Response;

class MetadataAction extends BaseAction
{

    /**
     * Display Service Provider Metadata in xml format.
     */
    public function run()
    {
        \Yii::$app->response->format = Response::FORMAT_XML;
        return $this->samlSsoComponent->getMetadata();
    }
}