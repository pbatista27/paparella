<?php
namespace controllers\personal\actions;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use controllers\personal\models\SearchModel;

class GridAction extends \yii\base\Action
{
	public $filterStatus;
	public $filterProfile;
	public $filterSinSucursal = false;

	public function init()
	{
		parent::init();
		$this->controller->model = new SearchModel();

		if($this->filterSinSucursal == true)
		{
			$this->controller->dataProvider = $this->controller->model->searchSinSucursal($this->filterProfile, Yii::$app->request->queryParams);
			return;
		}

		if(!empty($this->filterProfile))
			$this->controller->model->activo = $this->filterStatus;

		$this->controller->dataProvider = $this->controller->model->searchByProfile($this->filterProfile, Yii::$app->request->queryParams);
	}

	public function run()
	{
		switch (true)
		{
			case ($this->filterSinSucursal == true):
				$this->setViewParams('sin-sucursal');
 				return $this->controller->render('partial/_sinSucursalGridView');

			case ($this->filterStatus == true):
				$this->setViewParams('actives');
				return $this->controller->render('partial/_activeGridView');

			default:
				$this->setViewParams('inactives');
				return $this->controller->render('partial/_inactiveGridView');
				break;
		}
	}

	protected function setViewParams($target)
	{
		$controller = $this->controller;

		if($this->filterProfile == $controller->model::PROFILE_ADMIN_SUCURSAL)
			$controller->view->iconClass = 'star';
		else
			$controller->view->iconClass = 'users';

		switch(true)
		{
			////////////////////////////////////////////////////////////////////
			// administradores sin sucursal:
			case (($target == 'sin-sucursal') && ($this->filterProfile == $controller->model::PROFILE_ADMIN_SUCURSAL)):
				$controller->view->H1 = Yii::t('app','Administradores de sucursal sin sucursales');
				break;

			// docentes sin sucursal:
			case (($target == 'sin-sucursal') && ($this->filterProfile == $controller->model::PROFILE_DOCENTE)):
				$controller->view->H1 = Yii::t('app','Docentes sin sucursales');
				break;

			////////////////////////////////////////////////////////////////////
			//administradores activos:
			case (($target == 'actives') && ($this->filterProfile == $controller->model::PROFILE_ADMIN_SUCURSAL)):
				$controller->view->H1 = Yii::t('app','Administradores activos');
				break;

			// docentes activos:
			case (($target == 'actives') && ($this->filterProfile == $controller->model::PROFILE_DOCENTE)):
				$controller->view->H1 = Yii::t('app','Docentes activos');
				break;

			////////////////////////////////////////////////////////////////////
			//administradores activos:
			case (($target == 'inactives') && ($this->filterProfile == $controller->model::PROFILE_ADMIN_SUCURSAL)):
				$controller->view->H1 = Yii::t('app','Administradores inactivos');
				break;

			// docentes activos:
			case (($target == 'inactives') && ($this->filterProfile == $controller->model::PROFILE_DOCENTE)):
				$controller->view->H1 = Yii::t('app','Docentes inactivos');
				break;
		}

        $controller->view->breadcrumbs    = [
        	['label' =>  Yii::t('app','Personal administrativo') , 'url' => Url::toRoute([$controller->currentController . '/index' ]) ],
            ['label' =>  $controller->view->H1 					 , 'url' => Url::toRoute([$controller->currentController . '/' . $controller->action->id ]) ],
        ];
	}
}
