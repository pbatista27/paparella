<?php

$params   = require __DIR__ . '/params.php';
$db       = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => Yii::t('app','Escuela Leo Paparella'),
    'controllerMap' => [
        'account' => [
            'class' => 'controllers\account\Controller',
        ],
        'ajax'  => [
          'class' => 'controllers\ajax\Controller',
        ],
    ],
    'basePath'   =>dirname(__DIR__),
    'bootstrap'  => ['log'],
    'language'   => 'es-AR',
    'vendorPath' => VENDOR_PATH,
    'aliases' => [
        '@bower'            => '@vendor/bower-asset',
        '@npm'              => '@vendor/npm-asset',
        '@base'             => '@app/base',
        '@controllers'      => '@app/base/controllers',
        '@private-uploads'  => '@app/data/uploads',
        '@layouts'          => '@app/assets/dashboard/views/layouts',
    ],
    'modules' => [
        'cursos' => [
            'class' => 'base\modules\admin\cursos\Module',
        ],
        'cursadas' => [
            'class' => 'base\modules\cursadas\Module',
        ],
        'root' => [
            'class' => 'base\modules\Admin',
        ],
        'admin' => [
            'class' => 'base\modules\AdminSucursal',
        ],
        'docentes' => [
            'class' => 'base\modules\Docentes',
        ],
        'estudiantes' => [
            'class' => 'base\modules\Estudiantes',
        ],
        'leo-paparella' => [
            'class' => 'base\modules\Estadisticas',
        ],
    ],
    'components' => [
        'assetManager' => [
            'forceCopy' => (YII_ENV_DEV  || YII_ENV_TEST) ? true : false,
            'bundles' => [
                'yii\web\JqueryAsset'                => false,
                'yii\captcha\CaptchaAsset'           => false,
                'yii\grid\GridViewAsset'             => false,
                'yii\validators\PunycodeAsset'       => false,
                'yii\validators\ValidationAsset'     => false,
                'yii\web\YiiAsset'                   => false,
                'yii\widgets\ActiveFormAsset'        => false,
                'yii\widgets\MaskedInputAsset'       => false,
                'yii\widgets\PjaxAsset'              => false,
                'yii\bootstrap\BootstrapAsset'       => false,
                'yii\bootstrap\BootstrapPluginAsset' => false,
            ]
        ],
        'tools' => [
            'class' => 'base\helpers\Tools',
        ],
        'queries' => [
            'class' => 'base\helpers\Queries',
        ],
        'request' => [
            'cookieValidationKey' => 'ç·$%&/BSDVBNMJ/(&%$··$%&/()R/9+65"·$',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class'     => 'yii\i18n\PhpMessageSource',
                    'basePath'  => '@app/messages',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'name'  => 'adminSessionId',
        ],
        'user' => [
            'identityClass'     => 'base\models\UserIdentity',
            'loginUrl'          => ['/site/index'],
            'enableAutoLogin'   => true,
            'enableAutoLogin'   => true,
            'identityCookie'    => [
                'name'          => '_userIdentity',
                'httpOnly'      => true
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'logFile' => '@runtime/logs/admin/error.log',
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
                [
                    'logFile' => '@runtime/logs/admin/warning.log',
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                ],
                [
                    'logFile' => '@runtime/logs/admin/info.log',
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                ],
            ],
        ],

        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false,
            'suffix'            => '/',
            'rules'             => require('urlRules.php'),
        ],

        'view' => [
            'class' => 'base\View',
            'theme' => [
                'basePath' => '@app/assets/dashboard/views',
                'baseUrl'  => '@web',
                'pathMap'  => [
                    '@app/views' => '@app/assets/dashboard/views',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV)
{
    /*
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    */
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
