<?php
namespace controllers\sucursales\actions;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\sucursales\models\Sucursal;
use controllers\personal\models\Personal;
use base\helpers\Tools;

class UpdatePersonalAction extends \yii\base\Action
{
	public $perfil;
	public $keySucursal;
	public $key;
	public $modelSucursal;

	public function init()
	{
		parent::init();
		$this->modelSucursal = Sucursal::findOne(  Yii::$app->request->get($this->keySucursal, null) );

		if(is_null( $this->modelSucursal ))
			Tools::httpException(404);

		if(Yii::$app->request->isAjax !== true)
			Tools::httpException(400);
	}

	public function run()
	{
		$this->controller->model = Personal::findOne( Yii::$app->request->get($this->key, null) );

		if(is_null($this->controller->model))
			Tools::httpException(404);

		if(Yii::$app->request->isPost)
		{
			$messageSuccess = ($this->perfil == Personal::PROFILE_ADMIN_SUCURSAL) ? Yii::t('app', 'Administrador actualizado exitosamente!') : Yii::t('app', 'Docente actualizado exitosamente!');
			return $this->processForm($messageSuccess);
		}

		$this->setViewParams();
		return $this->controller->renderAjax('personal/form');
	}

	protected function setViewParams()
	{
		$controller = $this->controller;

		if($this->perfil == Personal::PROFILE_ADMIN_SUCURSAL)
		{
			$controller->view->H1 = Yii::t('app','Actualizar administrador');
			$controller->view->iconClass = 'star';
		}
		else{
			$controller->view->H1 = Yii::t('app','Actualizar docente');
			$controller->view->iconClass = 'users';
		}
	}

    protected function processForm($messageSuccess = null)
    {

        $this->controller->model->load( Yii::$app->request->post() );
        $this->controller->model->flagNotEditSucursal = true;

        if($this->controller->model->validate() === false)
        {
            return $this->controller->asJson([
                'status'     => false,
                'statusText' => Yii::t('app', 'Error al validar datos de entrada'),
                'errors'     => $this->controller->model->getClientErrors(),
            ]);
        }

        if($this->controller->model->save() === false)
        {

            return $this->controller->asJson([
                'status'     => false,
                'statusText' => Yii::t('app', 'Error al guardar los datos.. favor intente más tarde'),
                'errors'     => $this->controller->model->getClientErrors(),
            ]);
        }

        return $this->controller->asJson([
            'status'     => true,
            'statusCode' => 'Acción completada exitosamente!',
            'statusText' => $messageSuccess,
        ]);
    }
}
