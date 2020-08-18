<?php
namespace base\actions;

use Yii;
use yii\base\ViewNotFoundException;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;

class DeleteAction extends \yii\base\Action
{
	public $modelClass;
	public $key = 'id';
	public $messageSuccess;
	public $messageError;

	public function init()
	{
		parent::init();
		if(empty($this->messageSuccess))
			$this->messageSuccess = Yii::t('app', 'Registro eliminado exitosamente!');

		if(empty($this->messageError))
			$this->messageError = Yii::t('app', 'No es posible eliminar él registro seleccionado. Otros datos dependen de él.');
	}

	public function run()
	{
		$id        = (int) Yii::$app->request->getQueryParam($this->key, 0);
		$redirect  = Yii::$app->request->getQueryParam('redirect', null);
		$model     = $this->modelClass::findOne($id);

		if(is_null($model))
			Yii::$app->session->setFlash('success', $this->messageSuccess);

		else{
			try{
				if($model->delete())
					Yii::$app->session->setFlash('success', $this->messageSuccess);
				else
					Yii::$app->session->setFlash('danger', $this->messageError);
			}
			catch(\Exception $e){
				Yii::$app->session->setFlash('danger', $this->messageError);
			}
		}

		if(is_null($redirect))
			return $this->controller->goBack();
		else
			return $this->controller->redirect($redirect);
	}
}
