<?php
namespace base\modules\cursadas\controllers;

use yii;
use yii\helpers\Url;
use yii\helpers\Html;
use base\helpers\Tools;

use base\modules\cursadas\models\Cursada;
use base\modules\cursadas\models\FechaInicio;

class CronogramaController extends \base\Controller
{
	public $model;

	public function actionIndex($idCursada)
	{
		$this->model = Cursada::find()->where('id = :idCursada', [':idCursada' => $idCursada ])->one();

		if(is_null($this->model))
			Tools::httpException(404);

		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		$this->view->H1         = Yii::t('app', 'Cursada cronograma');
		$this->view->iconClass  = 'history';

		return $this->renderAjax('index');
	}

	public function actionUpdateFechaInicio($idCursada)
	{
		$this->model = FechaInicio::find()->where('id = :idCursada', [':idCursada' => $idCursada ])->one();

		if(is_null($this->model))
			Tools::httpException(404);

		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		$msnError = null;
		switch($this->model->status)
		{
			case 3:
				$msnError = Yii::t('app', 'No puede modificar la fecha de inicio para cursadas canceladas');
				break;

			case 2:
				$msnError = Yii::t('app', 'No puede modificar la fecha de inicio para cursadas finalizadas');
				break;

			case 1:
				$msnError = Yii::t('app', 'No puede modificar la fecha de inicio para cursadas en curso');
				break;
		}

		if(!is_null($msnError))
		{
			$this->view->H1         = Yii::t('app', 'Opción invalida');
			$this->view->iconClass  = 'times';
			return $this->renderAjax('no-editable', ['msn', $msnError]);
		}

		if(Yii::$app->request->isPost)
			return $this->processForm(Yii::t('app', 'Ha actualizado la fecha de inicio de la cursada exitosamente!'));

		$this->view->H1         = Yii::t('app', 'Cursada fecha de incio');
		$this->view->iconClass  = 'history';
		return $this->renderAjax('form-fecha-inicio');
	}

    public function processForm($messageSuccess = null)
    {
        if(!Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        $this->model->load( Yii::$app->request->post() );

        if($this->model->validate() === false)
        {
            return $this->asJson([
                'status'     => false,
                'statusText' => Yii::t('app', 'Error al validar datos de entrada'),
                'errors'     => $this->model->getClientErrors(),
            ]);
        }

        if($this->model->save() === false)
        {
            return $this->asJson([
                'status'     => false,
                'statusText' => Yii::t('app', 'Error al guardar los datos.. favor intente más tarde'),
                'errors'     => $this->model->getClientErrors(),
            ]);
        }

        return $this->asJson([
            'status'     => true,
            'statusCode' => 'Acción completada exitosamente!',
            'statusText' => $messageSuccess,
        ]);
    }
}
