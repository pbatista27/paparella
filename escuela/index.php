<?php

// comment out the following two lines when deployed to production
define ('VENDOR_PATH', __DIR__ . '/protected/vendor');
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require VENDOR_PATH	   		. '/autoload.php';
require VENDOR_PATH	   		. '/yiisoft/yii2/Yii.php';
$config = require __DIR__ 	. '/protected/config/web.php';

(new yii\web\Application($config))->run();
