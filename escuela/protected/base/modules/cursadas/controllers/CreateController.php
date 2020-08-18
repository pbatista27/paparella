<?php
namespace base\modules\cursadas\controllers;

use yii;
use yii\helpers\Url;
use yii\helpers\Html;
use base\helpers\Tools;
use base\modules\cursadas\models\Create;
use base\modules\cursadas\models\CursadaHorario;
use base\modules\cursadas\models\CronogramaActividades;
use app\models\Sucursal;
use \Datetime;

class CreateController extends \base\Controller
{
	public $model;
	public $step;
	public $lastStep;
	public $modelSucursal;
	public $session;
	public $rulesSucursal;
	public $sessionKey;

	const MAX_STEP = 3;

	public function actionIndex()
	{
		$this->loadModelSucursal();
		$this->rulesSucursal    = Url::ToRoute([ Yii::$app->user->identity->getPrefixProfileModule()  .'/sucursales/view' , 'id' => $this->modelSucursal->id ]);

		$this->sessionKey       = 'create-cursada-' . $this->modelSucursal->id;
		$this->session   		= Yii::$app->session->get($this->sessionKey, []);
		$this->lastStep  		= count($this->session) <= 0 ? 1 : count($this->session);
		$this->step      		= Yii::$app->request->get('step',1);

		if($this->step > static::MAX_STEP || $this->step < 1 )
			return $this->redirect([$this->currentController . '/index' , 'step' => $this->lastStep , 'idSucursal' => $this->modelSucursal->id ]);

		$this->setViewAttributes();

		switch($this->step)
		{
			case 2:
				if(count($this->session) < 1)
					Yii::$app->response->redirect([$this->currentController . '/index' , 'step' => $this->lastStep , 'idSucursal' => $this->modelSucursal->id ]);

				return $this->processHorario();

			case 3:
				if(count($this->session) < 2)
					Yii::$app->response->redirect([$this->currentController . '/index' , 'step' => $this->lastStep , 'idSucursal' => $this->modelSucursal->id ]);
				return $this->processExamen();

			default:
				return $this->processCursada();
		}
	}

	protected function setViewAttributes()
	{
		$this->view->iconClass  = 'plus';
		$this->view->H1         = Yii::t('app', 'Nueva cursada - paso {0}' , [ $this->step ]);
		$this->view->title      = $this->view->H1 . ' - ' .  Yii::$app->name ;

		$this->view->breadcrumbs    = [
			['label' => Yii::t('app', 'Sucursal {0}', [ Html::encode($this->modelSucursal->nombre) ]),  'url' => $this->rulesSucursal ],
			['label' =>  Yii::t('app','Nueva cursada - paso {0}', [$this->step ]) , 'url' => Url::toRoute([$this->currentController . '/index', 'step' => $this->step , 'idSucursal' => $this->modelSucursal->id  ])  ],
		];
	}

	protected function loadModelSucursal()
	{
		$id = Yii::$app->request->get('idSucursal', null);
		$this->modelSucursal = Sucursal::find()->where('id=:id', [':id'=> $id])->one();

		if(is_null($this->modelSucursal))
			Tools::httpException(404);
	}

	protected function loadSessionStep()
	{
		$session = isset($this->session[ 'step-' . $this->step ])  ? $this->session[ 'step-' . $this->step ] : [];
		if(empty($session))
			return;

		$this->model->load($session, '');
		$this->model->validate();
	}

	protected function processCursada()
	{
		$this->model = new Create([ 'scenario'=> 'create_datos_basicos', 'sucursal' => $this->modelSucursal->id ]);
		$this->loadSessionStep();

		if(Yii::$app->request->isPost)
		{
			$this->model->load(Yii::$app->request->post());

			if($this->model->validate())
			{
				$this->model->calcualteAttributesOnCreate();

				if($this->model->hasErrors() == false)
				{
					$this->session['step-1'] = $this->model->attributes;
					Yii::$app->session->set($this->sessionKey, $this->session);

					$urlRedirect = Url::toRoute([ $this->currentController . '/index' , 'step' => ($this->step+1), 'idSucursal' => $this->modelSucursal->id ]);
					return $this->redirect($urlRedirect);
				}
			}
		}

		return $this->render('index');
	}

	protected function processHorario()
	{
		$this->model = new CursadaHorario();
		$this->loadSessionStep();

		if(Yii::$app->request->isPost)
		{
			$this->model->load(Yii::$app->request->post());

			if($this->model->validate())
			{
				$fechaInicio       = new Datetime($this->session['step-1']['fecha_inicio']);
				$cantidadClases    = $this->session['step-1']['cantidad_clases'];
				$listadoDias       = $this->model->getDaysList();
				$fechasExcluidas   = explode(',', $this->model->fechas_excluidas);
				$cronograma        = Tools::datesFromDaysOnWeek($fechaInicio, $cantidadClases, $listadoDias, $fechasExcluidas);
				$horario		   = $this->model->getHorariosToString();

				$this->session['step-1']['fecha_inicio'] = $cronograma[0];
				$this->session['step-1']['fecha_fin']    = end($cronograma);

				if($this->model->hasErrors() == false)
				{
					$this->session['step-2'] = $this->model->attributes;
					$this->session['step-2']['cronograma'] = $cronograma;
					$this->session['step-2']['horarios']   = $this->model->getHorariosToString();

					Yii::$app->session->set($this->sessionKey, $this->session);

					$urlRedirect = Url::toRoute([ $this->currentController . '/index' , 'step' => ($this->step+1), 'idSucursal' => $this->modelSucursal->id ]);
					return $this->redirect($urlRedirect);
				}
			}
		}

		return $this->render('index');
	}

	protected function processExamen()
	{
		$this->model = new Create([ 'scenario'=> 'evaluacion']);
		$this->loadSessionStep();
		$this->model->cantidad_clases = $this->session['step-1']['cantidad_clases'];
		if(Yii::$app->request->isPost)
		{
			$this->model->load(Yii::$app->request->post());

			if($this->model->validate())
			{
				if($this->model->hasErrors() == false)
				{
					$this->session['step-3'] = [
						'dia_inicio_evaluacion' => $this->model->dia_inicio_evaluacion,
						'dia_fin_evaluacion'    => $this->model->dia_fin_evaluacion,
						'examen'				=> $this->model->examen,
					];

					Yii::$app->session->set($this->sessionKey, $this->session);
					if($this->saveModel())
					{
						Yii::$app->session->setFlash('success', Yii::t('app', 'Nueva cursada creada exitosamente'));
						return $this->redirect($this->rulesSucursal);
					}
					else{
						Yii::$app->session->setFlash('danger', Yii::t('app', 'Error al intentar crear nueva cursada, por favor sigua cada unos de los formularios en busca de un error'));
						return $this->redirect( Url::toRoute([ $this->currentController . '/index' , 'step' => 1, 'idSucursal' => $this->modelSucursal->id ]) );
					}
				}
			}
		}

		return $this->render('index');
	}

	protected function saveModel()
	{
		$model 							= new \app\models\Cursada($this->session['step-1']);
		$model->examen 					= $this->session['step-3']['examen'];
		$model->fecha_inicio_evaluacion = $this->session['step-2']['cronograma'][($this->session['step-3']['dia_inicio_evaluacion'] - 1)];
		$model->fecha_fin_evaluacion    = $this->session['step-2']['cronograma'][($this->session['step-3']['dia_fin_evaluacion'] - 1)];
		$model->horario 				= $this->session['step-2']['horarios'];

		$transaction = $model->getDb()->beginTransaction();
		try{
			if($model->save(false))
			{
				$modelCursadaHorario = new \app\models\CursadaHorario();
				$modelCursadaHorario->load($this->session['step-2'], '');
				$modelCursadaHorario->id_cursada = $model->id;

				if($modelCursadaHorario->save(false))
				{
					$transaction->commit();
					Yii::$app->session->remove($this->sessionKey);
					return true;
				}
			}
		}
		catch(\Exception $e){}

		$transaction->rollBack();
		return false;
	}
}
