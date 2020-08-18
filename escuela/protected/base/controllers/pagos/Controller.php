<?php
namespace controllers\pagos;

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
		$this->view->H1  = Yii::t('app','Pagos');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = 'institution';
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Administrar pagos')  , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];
		return $this->render('index');
	}

	public function actionCreate()
	{
		$this->view->H1  		= Yii::t('app','Nuevo pago');
		$this->view->title      = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass  = 'handshake-o';
		return $this->renderAjax('create');
	}

	public function actionDevolucion()
	{
		$this->view->H1  		= Yii::t('app','Devoluciones de pagos');
		$this->view->title      = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass  = 'handshake-o';
		return $this->renderAjax('create');
	}

	public function actionVencidos()
	{
		$this->view->H1  		= Yii::t('app','Pagos vencidos');
		$this->view->title      = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass  = 'handshake-o';
		return $this->renderAjax('create');
	}

	public function actionCompletados()
	{
		$this->view->H1  		= Yii::t('app','Pagos completados');
		$this->view->title      = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass  = 'handshake-o';
		return $this->renderAjax('create');
	}

	public function actionSearch()
	{
		$this->view->H1  		= Yii::t('app','Buscar pagos');
		$this->view->title      = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass  = 'search';
		return $this->renderAjax('create');
	}
}
