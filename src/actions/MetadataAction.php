<?php
namespace quartsoft\samlsso\actions;

use yii\web\Response;

class MetadataAction extends BaseAction
{

    /**
     * Display Service Provider Metadata in xml format.
     */
    public function run()
    {
        \Yii::$app->response->format = Response::FORMAT_XML;
        echo $this->samlSsoComponent->getMetadata();
    }
}