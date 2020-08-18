<?php
namespace controllers\sucursales\actions;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\sucursales\models\Sucursal;
use controllers\personal\models\Personal;
use base\helpers\Tools;

class CreatePersonalAction extends \yii\base\Action
{
	public $perfil;
	public $keySucursal;
	public $sucursal;

	public function init()
	{
		parent::init();
		$this->sucursal = Yii::$app->request->get($this->keySucursal, -1);
		$countSucursal  = Sucursal::find()->where('id = :id', [':id' => $this->sucursal ])->count();

		if($countSucursal != 1)
			Tools::httpException(404);

		if(Yii::$app->request->isAjax !== true)
			Tools::httpException(400);
	}

	public function run()
	{
		$this->controller->model = new Personal([
			'id_perfil'  => $this->perfil
		]);

		if(Yii::$app->request->isPost)
		{
			$messageSuccess = ($this->perfil == Personal::PROFILE_ADMIN_SUCURSAL) ? Yii::t('app', 'Administrador creado exitosamente!') : Yii::t('app', 'Docente creado exitosamente!');
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
			$controller->view->H1 = Yii::t('app','Nuevo administrador');
			$controller->view->iconClass = 'star';
		}
		else{
			$controller->view->H1 = Yii::t('app','Nuevo docente');
			$controller->view->iconClass = 'users';
		}
	}

    protected function processForm($messageSuccess = null)
    {

        $this->controller->model->load( Yii::$app->request->post() );

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

		try{
			$this->controller->model->db->createCommand()->insert('usuario_sucursal', [
				'id_sucursal' => $this->sucursal,
				'id_usuario'  => $this->controller->model->id,
			])->execute();
		}
		catch(\Exception $e){

		}

        return $this->controller->asJson([
            'status'     => true,
            'statusCode' => 'Acción completada exitosamente!',
            'statusText' => $messageSuccess,
        ]);
    }
}
