<?php
namespace controllers\personal;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\TraitControllers;
use controllers\personal\models\Personal;

class Controller extends \base\Controller
{
    use TraitControllers;
    public $dataProvider;

    public function actions()
    {
    	return [
			'toggle-status' => [
				'class' => 'controllers\personal\actions\ToggleStatusAction',
			],
    		// admin
			'admin-active' => [
				'class'  		=> 'controllers\personal\actions\GridAction',
				'filterProfile' => Personal::PROFILE_ADMIN_SUCURSAL,
				'filterStatus' 	=> true,
			],
			'admin-inactive' => [
				'class'  		=> 'controllers\personal\actions\GridAction',
				'filterProfile' => Personal::PROFILE_ADMIN_SUCURSAL,
				'filterStatus' 	=> false,
			],
			'admin-sinsucursal' => [
				'class'  	  		=> 'controllers\personal\actions\GridAction',
				'filterProfile' 	=> Personal::PROFILE_ADMIN_SUCURSAL,
				'filterSinSucursal' => true,
			],

			'admin-create' => [
				'class'  => 'controllers\personal\actions\CreateAction',
				'model'  => (new Personal(['id_perfil' => Personal::PROFILE_ADMIN_SUCURSAL ])),
			],

			'admin-update' => [
				'class'  => 'controllers\personal\actions\UpdateAction',
				'key'	 => 'id',
			],

			//docentes
			'doc-active' => [
				'class'  		=> 'controllers\personal\actions\GridAction',
				'filterStatus' 	=> true,
				'filterProfile' => Personal::PROFILE_DOCENTE,
			],
			'doc-inactive' => [
				'class'  		=> 'controllers\personal\actions\GridAction',
				'filterStatus' 	=> false,
				'filterProfile' => Personal::PROFILE_DOCENTE,
			],
			'doc-sinsucursal' => [
				'class'  	  		=> 'controllers\personal\actions\GridAction',
				'filterSinSucursal' => true,
				'filterProfile' 	=> Personal::PROFILE_DOCENTE,
			],
			'doc-create' => [
				'class'  => 'controllers\personal\actions\CreateAction',
				'model'  => (new Personal(['id_perfil' => Personal::PROFILE_DOCENTE ])),
			],
			'doc-update' => [
				'class'  => 'controllers\personal\actions\UpdateAction',
				'key'	 => 'id',
			],
    	];
    }

	public function actionIndex()
	{
		$this->view->H1  = Yii::t('app','Personal administrativo');

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Personal administrativo') , 'url' => Url::toRoute([$this->currentController . '/index' ])],
		];

		return $this->render('index', [
			'data' => Yii::$app->queries->getEstadisticasPersonal()
		]);
	}

	public function actionAdminDelete($id)
	{
		$redirect = Yii::$app->request->get( 'redirect', null);
		$model    = Personal::findOne($id);


		if(!is_null($model))
		{
			//@todo add transaccion
			try{
				$model->delete();
				$msn = Yii::t('app', 'Usuario eliminado exitosamente');
				Yii::$app->session->setFlash('success', $msn);
			}
			catch(\Exception $e){
				$msn = Yii::t('app', 'No es posbile eliminar el registro seleccionado... Otros datos dependen de él');
				Yii::$app->session->setFlash('danger', $msn);
			}
		}

		if(Yii::$app->request->isAjax)
			return;

		if(is_null($redirect))
			return $this->goHome();
		else
			return $this->redirect($redirect);
	}

	public function actionDocDelete($id)
	{
		$redirect = Yii::$app->request->get( 'redirect', null);
		$model    = Personal::findOne($id);

		if(!is_null($model))
		{
			try{
				$model->delete();
				$msn = Yii::t('app', 'Usuario eliminado exitosamente');
				Yii::$app->session->setFlash('success', $msn);
			}
			catch(\Exception $e){
				$msn = Yii::t('app', 'No es posbile eliminar el registro seleccionado... Otros datos dependen de él');
				Yii::$app->session->setFlash('danger', $msn);
			}
		}

		if(Yii::$app->request->isAjax)
			return;

		if(is_null($redirect))
			return $this->goHome();
		else
			return $this->redirect($redirect);
	}
}
