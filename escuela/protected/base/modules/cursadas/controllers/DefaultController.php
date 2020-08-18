<?php
namespace base\modules\cursadas\controllers;

use yii;
use yii\helpers\Url;
use yii\helpers\Html;
use base\helpers\Tools;
use base\modules\cursadas\models\Cursada;
use app\models\Sucursal;

class DefaultController extends \base\Controller
{
	public $model;
	public $modelSucursal;
	public $dataProvider;

	public function beforeAction($action)
	{
		if(parent::beforeAction($action) !== true)
			Tools::httpException(403);

		if(!in_array($action->id, ['delete', 'cancel', 'cronograma', 'examen', 'update']) )
		{
			$this->modelSucursal = Sucursal::find()->where('id = :id', [
				':id' => Yii::$app->request->get('idSucursal'),
			])->one();

			if(is_null($this->modelSucursal))
				Tools::httpException(404);
		}

		if(Yii::$app->user->identity->isAdmin())
			return true;

		if(Yii::$app->user->identity->isAdminSucursal())
			return true;

		return false;
	}

	public function actionPorIniciar()
	{
		$this->model 		 = new Cursada(['scenario' => 'search']);
		$this->model->status = 0;
		$this->dataProvider  = $this->model->search($this->modelSucursal->id, Yii::$app->request->queryParams );
		$this->dataProvider->query->andWhere('status = 0');

		if(Yii::$app->user->identity->isAdmin())
			$routeSucursal = Url::toRoute(['/root/sucursales/view', 'id' => $this->modelSucursal->id ]);
		else
			$routeSucursal = Url::toRoute(['/admin/sucursales/view', 'id' => $this->modelSucursal->id ]);

		$this->view->iconClass 		= 'file-o';
		$this->view->H1  			= Yii::t('app','Cursadas por iniciar');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' => Yii::t('app', 'Sucursal {nombre}', ['nombre' => $this->modelSucursal->nombre]),  'url' => $routeSucursal],
			['label' =>  Yii::t('app','Cursadas por iniciar') , 'url' => Url::toRoute([$this->currentController . '/' . $this->currentAction , 'idSucursal' => $this->modelSucursal->id ])],
		];

		return $this->render('grid-manager');
	}

	public function actionEnCurso($idSucursal)
	{
		$this->model 		= new Cursada(['scenario' => 'search']);
		$this->dataProvider = $this->model->search($this->modelSucursal->id, Yii::$app->request->queryParams );
		$this->model->status = 1;
		$this->dataProvider->query->andWhere('status = 1');

		if(Yii::$app->user->identity->isAdmin())
			$routeSucursal = Url::toRoute(['/root/sucursales/view', 'id' => $this->modelSucursal->id ]);
		else
			$routeSucursal = Url::toRoute(['/admin/sucursales/view', 'id' => $this->modelSucursal->id ]);

		$this->view->iconClass 		= 'file-o';
		$this->view->H1  			= Yii::t('app','Cursadas en curso');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' => Yii::t('app', 'Sucursal {nombre}', ['nombre' => $this->modelSucursal->nombre]),  'url' => $routeSucursal],
			['label' =>  Yii::t('app','Cursadas en curso') , 'url' => Url::toRoute([$this->currentController . '/' . $this->currentAction , 'idSucursal' => $this->modelSucursal->id ])],
		];

		return $this->render('grid-manager');
	}

	public function actionFinalizadas($idSucursal)
	{
		$this->model 		= new Cursada(['scenario' => 'search']);
		$this->dataProvider = $this->model->search($this->modelSucursal->id, Yii::$app->request->queryParams );
		$this->dataProvider->query->andWhere('status = 2');

		if(Yii::$app->user->identity->isAdmin())
			$routeSucursal = Url::toRoute(['/root/sucursales/view', 'id' => $this->modelSucursal->id ]);
		else
			$routeSucursal = Url::toRoute(['/admin/sucursales/view', 'id' => $this->modelSucursal->id ]);

		$this->view->iconClass 		= 'file-o';
		$this->view->H1  			= Yii::t('app','Cursadas finalizadas');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' => Yii::t('app', 'Sucursal {nombre}', ['nombre' => $this->modelSucursal->nombre]),  'url' => $routeSucursal],
			['label' =>  Yii::t('app','Cursadas finalizadas') , 'url' => Url::toRoute([$this->currentController . '/' . $this->currentAction , 'idSucursal' => $this->modelSucursal->id ])],
		];

		return $this->render('grid-manager');
	}

	public function actionCanceladas($idSucursal)
	{
		$this->model 		= new Cursada(['scenario' => 'search']);
		$this->dataProvider = $this->model->search($this->modelSucursal->id, Yii::$app->request->queryParams );
		$this->model->status = 1;
		$this->dataProvider->query->andWhere('status = 3');

		if(Yii::$app->user->identity->isAdmin())
			$routeSucursal = Url::toRoute(['/root/sucursales/view', 'id' => $this->modelSucursal->id ]);
		else
			$routeSucursal = Url::toRoute(['/admin/sucursales/view', 'id' => $this->modelSucursal->id ]);

		$this->view->iconClass 		= 'file-o';
		$this->view->H1  			= Yii::t('app','Cursadas canceladas');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' => Yii::t('app', 'Sucursal {nombre}',   ['nombre' => $this->modelSucursal->nombre]),  'url' => $routeSucursal],
			['label' =>  Yii::t('app','Cursadas canceladas') , 'url' => Url::toRoute([$this->currentController . '/' . $this->currentAction , 'idSucursal' => $this->modelSucursal->id ])],
		];

		return $this->render('grid-manager');
	}

	public function actionCreate($idSucursal)
	{
	}

	public function actionCronograma($id)
	{
	}

	public function actionExamen($id)
	{
	}

	public function actionCancel($id)
	{
		if(!Yii::$app->user->identity->isAdmin())
			Tools::httpException(403);

		$model = Cursada::findOne($id);
		if(is_null($model))
			Tools::httpException(404);

		if($model->status == 2 )
			Yii::$app->session->setFlash('danger', Yii::t('app','No es posible cancelar el registro selecciondo... Cursada finalizada'));

		else{
			$model->status = 3;
			$model->save(false, ['status']);
			Yii::$app->session->setFlash('success', Yii::t('app','Cursada cancelada exitosamente'));
		}

		if(!Yii::$app->request->isAjax)
		{
			if(!is_null($redirect))
				return $this->redirect($redirect);
			else
				return $this->goBack();
		}
	}

	public function actionUpdate($id)
	{

	}

	/*
	public function actionDelete($id)
	{
		if(!Yii::$app->user->identity->isAdmin())
			Tools::httpException(403);

		$model    = Cursada::findOne($id);
		$redirect = Yii::$app->request->get('redirect', null);

		if(!is_null($model))
		{
			if($model->status == 1)
				Yii::$app->session->setFlash('danger', Yii::t('app','No es posible eliminar el registro selecciondo... Cursada en curso'));

			else{
				try{
					$model->delete();
					Yii::$app->session->setFlash('success', Yii::t('app','Registro eliminado exitosamente'));
				}
				catch(\Exception $e){
					Yii::$app->session->setFlash('danger', Yii::t('app','No es posible eliminar el registro selecciondo... Otros datos dependen de el'));
				}
			}
		}

		if(!Yii::$app->request->isAjax)
		{
			if(!is_null($redirect))
				return $this->redirect($redirect);
			else
				return $this->goBack();
		}
	}


	public function actionDelete($id)
	{
		if(!Yii::$app->user->identity->isAdmin())
			Tools::httpException(403);

		$model    = Cursada::findOne($id);
		$redirect = Yii::$app->request->get('redirect', null);

		if(!is_null($model))
		{
			if($model->status == 1)
				Yii::$app->session->setFlash('danger', Yii::t('app','No es posible eliminar el registro selecciondo... Cursada en curso'));

			else{
				try{
					$model->delete();
					Yii::$app->session->setFlash('success', Yii::t('app','Registro eliminado exitosamente'));
				}
				catch(\Exception $e){
					Yii::$app->session->setFlash('danger', Yii::t('app','No es posible eliminar el registro selecciondo... Otros datos dependen de el'));
				}
			}
		}

		if(!Yii::$app->request->isAjax)
		{
			if(!is_null($redirect))
				return $this->redirect($redirect);
			else
				return $this->goBack();
		}
	}
	*/
}
