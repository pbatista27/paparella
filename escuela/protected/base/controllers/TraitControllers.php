<?php
namespace controllers;
use Yii;
use yii\web\HttpException;

trait TraitControllers
{
	public function getViewPath()
	{
		$class = new \ReflectionClass($this);
		return dirname( $class->getFilename()) . '/views';
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
