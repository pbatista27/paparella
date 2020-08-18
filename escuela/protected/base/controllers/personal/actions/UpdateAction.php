<?php
namespace controllers\personal\actions;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;
use controllers\personal\models\Personal;

class UpdateAction extends CreateAction
{
	public 		$key;
	protected 	$model;

	public function setModel($model)
	{
		throw new  \yii\base\InvalidConfigException(Yii::t('app', 'No disponible el setter al actualizar'));
	}

	public function run()
	{
		$id =  Yii::$app->request->get($this->key);
		$this->controller->model = Personal::findOne($id);
		if(!$this->controller->model)
			throw new HttpException( 404, Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

        if(Yii::$app->request->isPost)
            return $this->controller->processForm(Yii::t('app','Usuario modificado exitosamente!'));

        $this->setViewParams();
		return $this->controller->render('form');
	}

	protected function setViewParams()
	{
		$controller = $this->controller;

		if($controller->model->id_perfil == $controller->model::PROFILE_ADMIN_SUCURSAL)
		{
			$controller->view->H1 = Yii::t('app','Actualizar administrador de sucursal');
			$controller->view->iconClass = 'star';
		}
		else{
			$controller->view->iconClass = 'users';
			$controller->view->H1 = Yii::t('app','Actualizar docente');
		}

        $controller->view->breadcrumbs    = [
        	['label' =>  Yii::t('app','Personal administrativo') , 'url' => Url::toRoute([$controller->currentController . '/index' ]) ],
            ['label' =>  $controller->view->H1 					 , 'url' => Url::toRoute([$controller->currentController . '/' . $controller->action->id ]) ],
        ];
	}
}
