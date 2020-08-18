<?php
namespace controllers\sucursales\actions;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\sucursales\models\Sucursal;
use controllers\personal\models\Personal;

use base\helpers\Tools;

class IndexPersonalAction extends \yii\base\Action
{
	public $perfil;
	public $keySucursal;

	public function init()
	{
		parent::init();
		$this->controller->model = Sucursal::findOne( Yii::$app->request->get($this->keySucursal, null) );

		if(Yii::$app->request->isAjax !== true)
			Tools::httpException(400);

		if(is_null($this->controller->model))
			Tools::httpException(403);
	}

	public function run()
	{
		$this->setViewParams();
		return $this->controller->renderAjax('personal/index');
	}

	protected function setViewParams()
	{
		$controller = $this->controller;

		if($this->perfil == Personal::PROFILE_ADMIN_SUCURSAL)
		{
			$controller->view->H1 = Yii::t('app','Administradores');
			$controller->view->iconClass = 'star';
		}
		else{
			$controller->view->H1 = Yii::t('app','Docentes');
			$controller->view->iconClass = 'users';
		}
	}
}
