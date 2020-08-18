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

class CreateController extends \base\Controller
{
	public $model;

	public function actionIndex()
	{
		$this->loadModel();
		$this->view->H1             = Yii::t('app','Nuevo');
		$this->view->title          = Yii::t('app','Nuevo') . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = 'plus';

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  $this->view->H1 , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
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
				'statusCode' => $this->model->isNewRecord ? 'Registro creado exitosamente!' : 'Registro modificado exitosamente!',
				'statusText' => $statusText = Yii::t('app', '<h5 class="margin-v-15">curso <b>{nombre}</b> modificado exitosamente!</h5>', ['nombre' => $this->model->nombre ]),
			]);
		}

		return $this->render('@moduleLayouts/cursos/form');
	}

	public function actionProgramacion()
	{
		$this->loadModel();
		if($this->model->isNewRecord)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los datos basicos para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/index']));
		}

		$this->view->H1        = Yii::t('app','Programación');
		$this->view->iconClass = 'plus';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app', 'Nuevo')  , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
			['label' =>  $this->view->H1, 'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/programacion' ]) ],
		];

		return $this->render('@moduleLayouts/cursos/programacion');
	}

	public function actionMaterialPrograma()
	{
		$this->loadModel();
		if($this->model->isNewRecord)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los datos basicos para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/index']));
		}

		if($this->model->getProgramacionDataProvider()->query->count() == 0)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe la programación para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/programacion']));
		}


		$this->view->H1        = Yii::t('app','Material programa');
		$this->view->iconClass = 'edit';

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app', 'Nuevo')  , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
			['label' =>  $this->view->H1, 'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/material-programa' ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getMaterialProgramaDataProvider() ]);
	}

	public function actionMaterialDocentes()
	{
		$this->loadModel();

		if($this->model->isNewRecord)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los datos basicos para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/index']));
		}

		if($this->model->getMaterialProgramaDataProvider()->query->count() == 0)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe el material de programa para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/material-programa']));
		}

		$this->view->H1        = Yii::t('app','Material para docentes');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app', 'Nuevo')  , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
			['label' =>  $this->view->H1, 'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/material-docentes' ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getMaterialDocenteDataProvider() ]);
	}

	public function actionMaterialEstudiantes()
	{
		$this->loadModel();

		if($this->model->isNewRecord)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los datos basicos para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/index']));
		}

		if($this->model->getMaterialDocenteDataProvider()->query->count() == 0)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe el material para docentes para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/material-docentes']));
		}

		$this->view->H1        = Yii::t('app','Material para estudiantes');
		$this->view->iconClass = 'edit';

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app', 'Nuevo')  , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
			['label' =>  $this->view->H1, 'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/material-estudiantes' ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getMaterialEstudianteDataProvider() ]);
	}

	public function actionExamenes()
	{
		$this->loadModel();
		$this->view->H1        = Yii::t('app','Material para estudiantes');
		$this->view->iconClass = 'edit';

		if($this->model->isNewRecord)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los datos basicos para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/index']));
		}

		if($this->model->getMaterialEstudianteDataProvider()->query->count() == 0)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe el material para estudiantes para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/material-estudiantes']));
		}

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app', 'Nuevo')  , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
			['label' =>  $this->view->H1, 'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/examenes' ]) ],
		];

		return $this->render('@moduleLayouts/cursos/curso-contenido', ['dataProvider' => $this->model->getExamenDataProvider() ]);
	}

	public function actionSucursalesActivas()
	{
		$this->loadModel();

		if($this->model->isNewRecord)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los datos basicos para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/index']));
		}

		if($this->model->getExamenDataProvider()->query->count() == 0)
		{
			Yii::$app->session->setFlash('danger', Yii::t('app', 'Favor registe los examenes para el nuevo curso antes de continuar'));
			return $this->redirect(Url::toRoute([$this->currentController . '/examenes']));
		}

		$sucursales = Sucursal::find()->select('id, nombre')->asArray()->all();

		if(Yii::$app->request->isPost)
		{
			$list = Yii::$app->request->post('sucursal', []);
			$list = array_intersect($list, array_column($sucursales, 'id'));

			foreach ($list as $id_sucursal)
			{
				try{
					$model = new CursoSucursal([
						'id_sucursal' => $id_sucursal,
						'id_curso'	  => $this->model->id,
					]);

					$model->save(false);

				}
				catch(\Exception $e){

				}
			}

			$this->model->is_tmp = 0;
			$this->model->update(false, ['is_tmp']);
			Yii::$app->session->setFlash('success', Yii::t('app', 'nuevo curso {name} creado exitosamente', ['name' => Html::encode($this->model->nombre) ]));

			return $this->redirect(url::toRoute([ '/' . $this->module->id . '/default/index' ]));
		}

		$this->view->H1        = Yii::t('app','Sucursales activas');
		$this->view->iconClass = 'edit';

		$this->view->title          = $this->view->H1  . ' - ' .  Yii::$app->name ;

		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Cursos') , 'url' => Url::toRoute([ '/' . $this->module->id . '/default/index'])  ],
			['label' =>  Yii::t('app', 'Nuevo')  , 'url' => Url::toRoute([$this->currentController . '/index'])  ],
			['label' =>  $this->view->H1, 'url' => Url::toRoute([ '/' . $this->module->id . '/'. $this->id .'/sucursales-activas' ]) ],
		];

		return $this->render('@moduleLayouts/cursos/sucursales-activas-nuevo-curso', [
			'sucursales' => $sucursales,
		]);
	}

	public function actionCancel()
	{
		$this->model = DbModel::find()->where('is_tmp = 1')->one();
		if(!is_null($this->model))
			$this->model->delete();

		if(Yii::$app->request->isAjax)
			exit;

		return $this->redirect(url::toRoute([ '/' . $this->module->id . '/default/index' ]));
	}

	protected function loadModel()
	{
		$this->model = DbModel::find()->where('is_tmp = 1')->one();
		if(is_null($this->model))
		{
			$this->model = new DbModel([
				'activo' => 1,
				'is_tmp' => 1,
			]);
		}
	}
}
