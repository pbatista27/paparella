<?php
namespace controllers\personal\actions;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

class CreateAction extends \yii\base\Action
{
	protected $model;

	public function setModel($model)
	{
		$this->model = $model;
	}

	public function run()
	{
		$this->controller->model = $this->model;

        if(Yii::$app->request->isPost)
            return $this->controller->processForm(Yii::t('app','Usuario creado exitosamente!'));

        $this->setViewParams();
		return $this->controller->render('form');
	}

	protected function setViewParams()
	{
		$controller = $this->controller;

		if($controller->model->id_perfil == $controller->model::PROFILE_ADMIN_SUCURSAL)
		{
			$controller->view->H1 = Yii::t('app','Nuevo administradores de sucursal');
			$controller->view->iconClass = 'star';
		}
		else{
			$controller->view->iconClass = 'users';
			$controller->view->H1 = Yii::t('app','Nuevo docente');
		}

        $controller->view->breadcrumbs    = [
        	['label' =>  Yii::t('app','Personal administrativo') , 'url' => Url::toRoute([$controller->currentController . '/index' ]) ],
            ['label' =>  $controller->view->H1 					 , 'url' => Url::toRoute([$controller->currentController . '/' . $controller->action->id ]) ],
        ];
	}
}
