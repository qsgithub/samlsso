<?php
$urlManager = Yii::$app->urlManager;
$spBaseUrl = $urlManager->getHostInfo() . $urlManager->getBaseUrl();
return [
    'debug' => true,
    'sp' => [
        'entityId' => 'https://testsp2.aai.dfn.de/shibboleth',
        'assertionConsumerService' => [
            'url' => 'https://testsp2.aai.dfn.de/Shibboleth.sso/SAML2/POST',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],
        'singleLogoutService' => [
            'url' => 'https://testsp2.aai.dfn.de/Shibboleth.sso/SLO/POST',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
        ],
    ],
    'idp' => [
        'entityId' => 'https://testidp2.aai.dfn.de/idp/shibboleth',
        'singleSignOnService' => [
            'url' => 'https://testsp2.aai.dfn.de/Shibboleth.sso/Login',
            'binding' => 'urn:oasis:names:tc:SAML:profiles:SSO:request-init',
        ],
        'singleLogoutService' => [
            'url' => 'https://testsp2.aai.dfn.de/Shibboleth.sso/SLO/Redirect',
            'binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
        ],
        'x509cert' => 'your certificate',
    ],
];



