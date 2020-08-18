<?php
namespace base\modules\cursadas\controllers;

use yii;
use yii\helpers\Url;
use yii\helpers\Html;
use base\helpers\Tools;
use app\models\Cursada;
use app\models\CursadaDocente;

class PagosController extends \base\Controller
{
	public $modelCursada;
	public $model;

	public function init()
	{
		parent::init();

		$this->modelCursada = Cursada::find()->where('id = :idCursada', [':idCursada' => Yii::$app->request->get('idCursada')])->one();

		if(is_null($this->modelCursada))
			Tools::httpException(404);
	}


	public function actionIndex($idCursada)
	{
		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		$this->view->H1         = Yii::t('app', ' Cursada pagos');
		$this->view->iconClass  = 'credit-card-alt';

		return $this->renderAjax('index');
	}

	public function actionAdd($idCursada, $id)
	{
	}

	public function actionRemove($idCursada, $id)
	{
	}
}
