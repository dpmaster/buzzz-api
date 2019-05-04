Buzzz api
=========

Install
-------
```
composer require buzzz/api
```

**index.php**
```
<?php
include "vendor/autoload.php";

use Buzzz\Api\Api;

$api = new Api();

$api->add([
    'pattern' => '/:controller/:action/',
    'controller_namespace' => '\\App\\Controller\\',
]);

$api->run();
```


**.htaccess**
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_METHOD} !OPTIONS
RewriteRule ^(.*)$ index.php [L]
```