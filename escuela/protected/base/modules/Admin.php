<?php
namespace base\modules;
use Yii;

class Admin extends \base\Module
{
    public $controllerMap = [
		'estadisticas' => [
			'class' => 'controllers\estadisticas\Controller',
		],
		'configuracion' => [
			'class' => 'controllers\configuracion\Controller',
		],
		'sucursales' => [
			'class' => 'controllers\sucursales\Controller',
		],
    	'personal-administrativo' => [
    		'class' => 'controllers\personal\Controller',
    	],
    	'estudiantes' => [
    		'class' => 'controllers\estudiantes\Controller',
    	],
        'pagos' => [
            'class' => 'controllers\pagos\Controller',
        ],
        'pre-inscripciones' => [
            'class' => 'controllers\preinscripciones\Controller',
        ],
    ];

    public $defaultRoute = 'estadisticas';

    public function init()
    {
        parent::init();
    }

    public function checkAccessByProfile()
    {
    	return !(Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin());
    }
}
