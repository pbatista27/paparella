<?php
namespace controllers\sucursales\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\sucursales\models\Sucursal;
use controllers\personal\models\SearchModel;
use base\helpers\Tools;

class ListPersonalAction extends \yii\base\Action
{
	public $perfil;
	public $keySucursal;
	public $modelSucursal;

	public function init()
	{
		$this->modelSucursal = Sucursal::findOne(Yii::$app->request->get($this->keySucursal));

		if(is_null($this->modelSucursal))
			Tools::httpException(404);
	}

	public function run()
	{
		$this->controller->model = new SearchModel();
		$this->controller->model->load(Yii::$app->request->queryParams);

		$baseQuery   = $this->controller->model::find();
		$baseQuery->join('INNER JOIN', 'usuario_sucursal as us', 'us.id_usuario = usuario.id');
		$baseQuery->join('INNER JOIN', 'sucursal         as  s', 's.id = us.id_sucursal');
		$baseQuery->andWhere('s.id = :idSucursal', [ ':idSucursal' => Yii::$app->request->get($this->keySucursal, -1) ]);
		$baseQuery->andWhere('id_perfil = :idPerfil',    [':idPerfil' => $this->perfil]);
		$this->controller->model->addCommonFilters($baseQuery);

		$data = (object) [
			'actives'   => new ActiveDataProvider([
				'query' => (clone $baseQuery)->andWhere('usuario.activo = 1'),
				'pagination' => [
					'pageSize' => 20
				],
				'sort' => [
					'defaultOrder'=>[
						'id' => SORT_DESC,
					]
				]
			]),

			'inactives'   => new ActiveDataProvider([
				'query' => (clone $baseQuery)->andWhere('usuario.activo = 0'),
				'pagination' => [
					'pageSize' => 20
				],
				'sort' => [
					'defaultOrder'=>[
						'id' => SORT_DESC,
					]
				]
			]),
		];
		$this->setViewParams();
		return $this->controller->render('personal/gridview', ['data'=> $data]);
	}

	protected function setViewParams()
	{
		$controller = $this->controller;

		if($this->perfil == SearchModel::PROFILE_ADMIN_SUCURSAL)
		{
			$controller->view->H1 = Yii::t('app','Administradores de sucursal');
			$controller->view->iconClass = 'star';
		}
		else{
			$controller->view->H1 = Yii::t('app','Docentes de sucursal');
			$controller->view->iconClass = 'users';
		}

		$controller->view->breadcrumbs    = [
			['label' => Html::encode(Yii::t('app', 'Sucursal {nombre}', ['nombre' => $this->modelSucursal->nombre ])), 'url' => Url::toRoute([$controller->currentController . '/view', 'id' =>  $this->modelSucursal->id ])  ],
			['label' =>  $controller->view->H1 , 'url' => Url::toRoute([$controller->currentController . '/' . $controller->action->id , 'idSucursal' => $this->modelSucursal->id  ]) ],
		];

	}
}
