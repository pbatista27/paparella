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

use base\modules\admin\cursos\models\Sucursal;
use base\modules\admin\cursos\models\CursoSucursal;
use base\modules\admin\cursos\models\Curso as DbModel;

class DefaultController extends \base\Controller
{
	public $model;

	public function actions()
	{
		return [
			'delete' => [
				'class'      => '\base\actions\DeleteAction',
				'modelClass' => DbModel::ClassName(),
			],

			'toggle-status' => [
				'class' => '\base\actions\ToggleStatusAction',
				'modelClass' => DbModel::ClassName(),
			],
		];
	}

	public function actionIndex()
	{
		$this->view->H1             = Yii::t('app','Listado de cursos');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = 'file-text-o';
		$this->view->breadcrumbs    = [
			['label' =>  $this->view->H1 , 'url' => $this->currentUrl  ],
		];

		$params = [
			'activos'        => new ActiveDataProvider([
				'query'      => DbModel::find()->where('activo = 1 and is_tmp = 0'),
				'pagination' => false,
				'sort' => [
					'defaultOrder'=>[
						'id' => SORT_DESC,
					]
				]
			]),

			'inactivos' => new ActiveDataProvider([
				'query'      => DbModel::find()->where('activo = 0 and is_tmp = 0'),
				'pagination' => false,
				'sort' => [
					'defaultOrder'=>[
						'id' => SORT_DESC,
					]
				]
			]),
		];

		return $this->render('index', $params);
	}

	public function actionUpdate($id)
	{
		$this->model = DbModel::findOne($id);

		$this->view->H1             = Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]);
		$this->view->iconClass      = 'edit';

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  $this->view->H1 , 'url' => Url::toRoute([$this->currentController . '/update', 'id' => $id])  ],
		];

		if(Yii::$app->request->isPost)
		{
            if(!Yii::$app->request->isAjax)
                throw new HttpException(400, Yii::t('app', 'Petición invalida'));

			$this->model->load( Yii::$app->request->post() );
			$this->model->foto_promocional = UploadedFile::getInstance($this->model, 'foto_promocional');

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
				'statusText' => $statusText = Yii::t('app', '<h5 class="margin-v-15">curso <b>{nombre}</b> modificado exitosamente!</h5>', ['nombre' => $this->model->nombre ]),
			]);
		}

		return $this->render('@moduleLayouts/cursos/form');
	}

	public function actionProgramacion($id)
	{
		$this->model = DbModel::findOne($id);

		$this->view->H1        = Yii::t('app','Programación');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') ,  												'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]), 		'url' => Url::toRoute([ '/' . $this->module->id . '/default/update', 'id' => $this->model->id ]) ],
			['label' =>  $this->view->H1,  															'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/programacion', 'id' => $this->model->id ]) ],
		];

		return $this->render('@moduleLayouts/cursos/programacion');
	}

	public function actionMaterialPrograma($id)
	{
		$this->model = DbModel::findOne($id);

		$this->view->H1        = Yii::t('app','Material programa');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') ,  												'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]), 		'url' => Url::toRoute([ '/' . $this->module->id . '/default/update', 'id' => $this->model->id ]) ],
			['label' =>  $this->view->H1,  															'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/material-programa', 'id' => $this->model->id ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getMaterialProgramaDataProvider() ]);
	}

	public function actionMaterialDocentes($id)
	{
		$this->model = DbModel::findOne($id);

		$this->view->H1        = Yii::t('app','Material para docentes');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') ,  												'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]), 		'url' => Url::toRoute([ '/' . $this->module->id . '/default/update', 'id' => $this->model->id ]) ],
			['label' =>  $this->view->H1,  															'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/material-docentes', 'id' => $this->model->id ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getMaterialDocenteDataProvider() ]);
	}

	public function actionMaterialEstudiantes($id)
	{
		$this->model = DbModel::findOne($id);
		if(is_null($this->model))
			throw new NotFoundHttpException( Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

		$this->view->H1        = Yii::t('app','Material para estudiantes');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') ,  												'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]), 		'url' => Url::toRoute([ '/' . $this->module->id . '/default/update', 'id' => $this->model->id ]) ],
			['label' =>  $this->view->H1,  															'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/material-estudiantes', 'id' => $this->model->id ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getMaterialEstudianteDataProvider() ]);
	}

	public function actionExamenes($id)
	{
		$this->loadModel($id);
		$this->view->H1        = Yii::t('app','Material para estudiantes');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') ,  												'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]), 		'url' => Url::toRoute([ '/' . $this->module->id . '/default/update', 'id' => $this->model->id ]) ],
			['label' =>  $this->view->H1,  															'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/examenes', 'id' => $this->model->id ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getExamenDataProvider() ]);
	}

	public function actionSucursalesActivas($id)
	{
		$this->loadModel($id);

		$this->view->H1        = Yii::t('app','Sucursales activas');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') ,  												'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app','Editar {nombre}' , ['nombre' => $this->model->nombre]), 		'url' => Url::toRoute([ '/' . $this->module->id . '/default/update', 'id' => $this->model->id ]) ],
			['label' =>  $this->view->H1,  															'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/sucursales-activas', 'id' => $this->model->id ]) ],
		];

		return $this->render('@moduleLayouts/cursos/sucursales-activas', [
			'sucursales' 		 => Sucursal::find()->select('id, nombre')->asArray()->all(),
			'sucursalesActivas'  => array_column( $this->model->getCursoSucursals()->select('id_sucursal')->asArray()->all(), 'id_sucursal'),
		]);
	}

	public function actionStatusSucursal($id, $idSucursal)
	{
		$this->loadModel($id);
		$idSucursal    = (int) $idSucursal;
		$sucursales    = array_column(Sucursal::find()->select('id')->asArray()->all(), 'id');
		$cursoSucursal = $this->model->getCursoSucursals()->where('id_sucursal = :id_sucursal', [':id_sucursal' => $idSucursal ])->one();

		switch (true)
		{
			// no existe la $idSucursal
			case (!in_array($idSucursal, $sucursales)):
				return $this->asJson(['status' => false ]);
				break;

			case (is_null($cursoSucursal)):

				$cursoSucursal = new CursoSucursal([
					'id_sucursal' => $idSucursal,
					'id_curso'	  => $this->model->id,
				]);

				if($cursoSucursal->save(false) != true)
				{
					return $this->asJson([
						'status' 	  => false,
						'statusCode'  => Yii::t('yii', 'Error'),
						'statusText'  => Yii::t('app', 'Error al intentar agregar nueva sucursal. favor intente nuevamente'),
					]);
				}

				return $this->asJson([
					'status' => true,
				]);
				break;

			default:
				$transaction = $cursoSucursal->getDb()->beginTransaction();
				try{
					$status = $cursoSucursal->delete();

					if($status == true)
					{
						$transaction->commit();
						return $this->asJson([
							'status' => true,
						]);
					}
				}
				catch(\Exception $e){
					$status = false;
					$transaction->rollBack();
				}

				return $this->asJson([
					'status' 	  => false,
					'statusCode'  => Yii::t('app', 'Acción no valida'),
					'statusText'  => Yii::t('app', 'No es posible eliminar él registro seleccionado. Otros datos dependen de él.'),
				]);

				break;
		}
	}

	protected function loadModel($id, $exceptionOnNull = true)
	{
		$this->model =  DbModel::findOne($id);

		if($exceptionOnNull == true && is_null($this->model))
			throw new NotFoundHttpException( Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

		return !(is_null($this->model));
	}
}
