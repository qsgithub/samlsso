# Yii 2 Saml

Connect Yii 2 application to a Saml Identity Provider for Single Sign On

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Later run

```
php composer.phar require --prefer-dist quartsoft/samlsso "dev-master"
```

or add

```
"quartsoft/samlsso": "dev-master"
```

to the require section of your `composer.json` file.

Configuration
-------------

Register ``quartsoft\samlsso\Saml`` to your components in ``config/web.php``.

```php
'components' => [
    'samlsso' => [
        'class' => 'quartsoft\samlsso\Samlsso',
        'configFile' => '@common/config/samlcofig.php' // OneLogin_Saml config file (Optional)
    ]
]
```

This component requires a ``OneLogin_Saml`` configuration stored in a php file. The default value for ``configFile`` is ``@common/config/samlcofig.php`` so make sure to create this file before. This file must returns the ``OneLogin_Saml`` configuration. See this [link](https://github.com/onelogin/php-saml/blob/master/settings_example.php) for example configuration.

```php
<?php
return [
    'sp' => [
        'entityId' => '',
        'assertionConsumerService' => [
            'url' => '',
            'binding' => '',
        ],
        'singleLogoutService' => [
            'url' => '',
            'binding' => '',
        ]
    ],

    'idp' => [
        'entityId' => '',
        'singleSignOnService' => [
            'url' => '',
            'binding' => '',
        ],
        'singleLogoutService' => [
            'url' => '',
            'binding' => '',
        ],
        'x509cert' => '',
    ],
];
```

Example configuration file you can find [here](https://github.com/Erlang333/samlsso/tree/master/src/sampleconfig).

Usage
-----

Your controller, where you use actionLogin must be inherited from SamlController. And add array_merge in method actions().

```php

use quartsoft\samlsso\controllers\SamlController;

class SiteController extends SamlController
{

...

    public function actions()
    {
        $actions = parent::actions();

        $currentActions = [
            'your action' => [
                'class' => 'your class',
            ],
            ...
        ];

        return array_merge($actions, $currentActions);

    }

...

}
```

Finally
-------

For more information see [onelogin/php-saml](https://github.com/onelogin/php-saml) library .
