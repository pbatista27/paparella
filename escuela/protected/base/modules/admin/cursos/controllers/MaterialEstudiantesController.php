<?php
namespace base\modules\admin\cursos\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;
use yii\web\UploadedFile;

use base\modules\admin\cursos\models\Curso;
use base\modules\admin\cursos\models\MaterialEstudiante as DbModel;

class MaterialEstudiantesController extends \base\Controller
{
	public $model;
	public $modelCurso;

	public function beforeAction($action)
	{
		if(parent::beforeAction($action) == false)
			return false;

        if(!Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

		$idCurso 		  = Yii::$app->request->getQueryParam('idCurso', null);
		$this->pjaxId     = Yii::$app->request->getQueryParam('pjaxId',  null);
		$this->modelCurso = Curso::find()->where('id = :id', [':id' => $idCurso])->one();

		if(is_null($this->modelCurso))
			throw new NotFoundHttpException( Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

		return true;
	}

	public function actionUpdate($id)
	{
		$this->view->iconClass = 'edit';
		$this->view->H1        = Yii::t('app','Editar material para estudiantes');
		$this->model 	       = DbModel::find()->where('id = :id', [':id' => $id ])->one();

		if(is_null($this->modelCurso))
			throw new NotFoundHttpException( Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

		if(Yii::$app->request->isPost)
		{

			$this->model->load( Yii::$app->request->post() );
			$this->model->archivo = UploadedFile::getInstance($this->model, 'archivo');

			if($this->model->validate() === false)
			{
				return $this->asJson([
					'status' 	 => false,
					'statusText' => Yii::t('app', 'Error al validar datos de entrada'),
					'errors'	 => $this->model->getClientErrors(),
				]);
			}

			if($this->model->save() === false)
			{
				return $this->asJson([
					'status' 	 => false,
					'statusText' => Yii::t('app', 'Error al guardar los datos.. favor intente más tarde'),
					'errors'	 => $this->model->getClientErrors(),
				]);
			}

			return $this->asJson([
				'status'     => true,
				'statusCode' => 'Registro modificado exitosamente!',
				'statusText' => $statusText = Yii::t('app', '<h5 class="margin-v-15">Material para estudiantes <b>{nombre}</b> modificado exitosamente!</h5>', ['nombre' => $this->model->nombre ]),
			]);
		}

		return $this->renderAjax('@moduleLayouts/curso-contenido/form');
	}

	public function actionCreate()
	{
		$this->view->iconClass = 'plus';
		$this->view->H1        = Yii::t('app','Material para estudiantes');
		$this->model 	       = new DbModel();

		if(Yii::$app->request->isPost)
		{

			$this->model->load( Yii::$app->request->post() );
			$this->model->archivo = UploadedFile::getInstance($this->model, 'archivo');
			$this->model->id_curso = $this->modelCurso->id;

			if($this->model->validate() === false)
			{
				return $this->asJson([
					'status' 	 => false,
					'statusText' => Yii::t('app', 'Error al validar datos de entrada'),
					'errors'	 => $this->model->getClientErrors(),
				]);
			}

			if($this->model->save() === false)
			{
				return $this->asJson([
					'status' 	 => false,
					'statusText' => Yii::t('app', 'Error al guardar los datos.. favor intente más tarde'),
					'errors'	 => $this->model->getClientErrors(),
				]);
			}

			return $this->asJson([
				'status'     => true,
				'statusCode' => 'Registro creado exitosamente!',
				'statusText' => $statusText = Yii::t('app', '<h5 class="margin-v-15">Nuevo material para estudiantes <b>{nombre}</b> creado exitosamente!</h5>', ['nombre' => $this->model->nombre ]),
			]);
		}

		return $this->renderAjax('@moduleLayouts/curso-contenido/form');
	}

	//@todod pasar a un action
	public function actionDelete($id)
	{
		$this->model      =  DbModel::findOne($id);
		$this->modelCurso = $this->model->getCurso()->one();
		if(is_null($this->model))
			return;

		$counts = DbModel::find()->select('id')->where('id_curso =:id_curso and id_tipo_contenido = :tipo_contenido', [
			':id_curso' 		 => $this->modelCurso->id,
			':tipo_contenido' 	 => $this->model->id_tipo_contenido,
		])->count();

		if($counts > 0 || $this->modelCurso->is_tmp == true)
			$this->model->delete();
	}
}
