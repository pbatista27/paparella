<?php
namespace base\modules;
use Yii;

class AdminSucursal extends \base\Module
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
    	'cursos' => [
    		'class' => 'controllers\cursos\Controller',
    	],
    	'estudiantes' => [
    		'class' => 'controllers\estudiantes\Controller',
    	],
    	'cursadas' => [
    		'class' => 'controllers\cursadas\Controller',
    	],
    ];

    public $defaultRoute = 'estadisticas';

    public function init()
    {
        parent::init();
    }

    public function checkAccessByProfile()
    {
    	return !(Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdminSucursal() );
    }
}
