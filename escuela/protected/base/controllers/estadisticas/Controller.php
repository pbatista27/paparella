<?php
namespace controllers\estadisticas;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\TraitControllers;

class Controller extends \base\Controller
{
    use TraitControllers;

	public function actionIndex()
	{
		$this->view->H1  = Yii::t('app','Estadisticas generales');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "pie";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estadisticas Generales')  , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];
		return $this->render('index');
	}

	public function actionSucursales($id = null)
	{
		$this->view->H1  			= Yii::t('app','Estadisticas para sucursales');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "pie";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estadisticas Generales') , 'url' => Url::toRoute([$this->currentController . '/index' 		]) ],
			['label' =>  Yii::t('app','Sucursales')				, 'url' => Url::toRoute([$this->currentController . '/sucursales' 	]) ],
		];
		return $this->render('index');
	}

	public function actionDocentes($idSucursal = null)
	{
		$this->view->H1  			= Yii::t('app','Estadisticas para docentes');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "pie";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estadisticas Generales')  , 'url' => Url::toRoute([$this->currentController . '/index' 									 ])],
			['label' =>  Yii::t('app','Sucursales')				 , 'url' => Url::toRoute([$this->currentController . '/sucursales' 								 ])],
			['label' =>  'AQUI NOMBRE SUCURSAL'			 	 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' , 'id' 		  => $idSucursal ])],
			['label' =>  Yii::t('app','Docentes') 			  	 , 'url' => Url::toRoute([$this->currentController . '/docentes'   , 'idSucursal' => $idSucursal ])],
		];
		return $this->render('index');
	}

	public function actionEstudiantes($idSucursal = null)
	{
		$this->view->H1  = Yii::t('app','Estadisticas para estudiantes');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "pie";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estadisticas Generales')  , 'url' => Url::toRoute([$this->currentController . '/index' 									  ])],
			['label' =>  Yii::t('app','Sucursales')			 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' 								  ])],
			['label' =>  'AQUI NOMBRE SUCURSAL'			 	 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' , 'id' 		   => $idSucursal ])],
			['label' =>  Yii::t('app','Estudiantes') 			 , 'url' => Url::toRoute([$this->currentController . '/estudiantes' , 'idSucursal' => $idSucursal ])],
		];
		return $this->render('index');
	}

	public function actionPagos($idSucursal = null)
	{
		$this->view->H1  = Yii::t('app','Estadisticas de pagos');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "pie";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estadisticas Generales')  , 'url' => Url::toRoute([$this->currentController . '/index' 									  ])],
			['label' =>  Yii::t('app','Sucursales')			 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' 								  ])],
			['label' =>  'AQUI NOMBRE SUCURSAL'			 	 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' , 'id' 		   => $idSucursal ])],
			['label' =>  Yii::t('app','Estudiantes') 			 , 'url' => Url::toRoute([$this->currentController . '/estudiantes' , 'idSucursal' => $idSucursal ])],
		];
		return $this->render('index');
	}

	public function actionCursadas($idSucursal = null)
	{
		$this->view->H1  = Yii::t('app','Estadisticas de cursadas');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "pie";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estadisticas Generales')  , 'url' => Url::toRoute([$this->currentController . '/index' 									  ])],
			['label' =>  Yii::t('app','Sucursales')			 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' 								  ])],
			['label' =>  'AQUI NOMBRE SUCURSAL'			 	 	 , 'url' => Url::toRoute([$this->currentController . '/sucursales' , 'id' 		   => $idSucursal ])],
			['label' =>  Yii::t('app','Cursadas')		 		 , 'url' => Url::toRoute([$this->currentController . '/pagos'      , 'idSucursal' => $idSucursal ])],
		];

		return $this->render('index');
	}
}
