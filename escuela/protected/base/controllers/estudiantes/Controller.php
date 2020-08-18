<?php
namespace controllers\estudiantes;

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
		$this->view->H1  = Yii::t('app','Estudiantes');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "institution";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Estudiantes')  , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];
		return $this->render('index');
	}

	public function actionCreate()
	{
	}

	public function actionView()
	{
	}

	public function actionUpdate($id)
	{
	}
}
