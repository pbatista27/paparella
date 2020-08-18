<?php
namespace controllers\preinscripciones;

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
		$this->view->H1  = Yii::t('app','Pre-inscripciones');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "institution";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Pre-inscripciones')  , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];
		return $this->render('index');
	}

	public function actionEstudiantesRegulares()
	{
		$this->view->H1  = Yii::t('app','Pre-inscripciones');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "institution";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Pre-inscripciones')  , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];
		return $this->render('index');
	}

	public function actionNuevoIngreso()
	{
		$this->view->H1  = Yii::t('app','Pre-inscripciones');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "institution";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Pre-inscripciones')  , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];
		return $this->render('index');
	}
}
