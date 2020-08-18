<?php
namespace controllers\sucursales;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;
use yii\data\ActiveDataProvider;

use base\helpers\Tools;
use controllers\personal\models\Personal;
use controllers\sucursales\models\Sucursal  as DbModel;
use controllers\TraitControllers;


class Controller extends \base\Controller
{
	use TraitControllers;

	public function actions()
	{
		return [
			'toggle-status' => [
				'class' => '\base\actions\ToggleStatusAction',
				'modelClass' => DbModel::ClassName(),
			],
			'administradores' => [
				'class' 		=> '\controllers\sucursales\actions\IndexPersonalAction',
				'perfil' 		=> Personal::PROFILE_ADMIN_SUCURSAL,
				'keySucursal' 	=> 'idSucursal',
			],
			'administradores-list' => [
				'class' 		=> '\controllers\sucursales\actions\ListPersonalAction',
				'perfil' 		=> Personal::PROFILE_ADMIN_SUCURSAL,
				'keySucursal' 	=> 'idSucursal',
			],

			'administradores-toggle-status' => [
				'class' 		=> '\controllers\personal\actions\ToggleStatusAction',
				'key' 			=> 'id',
			],

			'administradores-create' => [
				'class' 		=> '\controllers\sucursales\actions\CreatePersonalAction',
				'perfil' 		=> Personal::PROFILE_ADMIN_SUCURSAL,
				'keySucursal' 	=> 'idSucursal',
			],

			'administradores-update' => [
				'class' 		=> '\controllers\sucursales\actions\UpdatePersonalAction',
				'key' 			=> 'id',
				'keySucursal'	=> 'idSucursal',
				'perfil'		=> Personal::PROFILE_ADMIN_SUCURSAL,
			],

			'docentes' => [
				'class' 		=> '\controllers\sucursales\actions\IndexPersonalAction',
				'perfil' 		=> Personal::PROFILE_DOCENTE,
				'keySucursal' 	=> 'idSucursal',
			],
			'docentes-create' => [
				'class' 		=> '\controllers\sucursales\actions\CreatePersonalAction',
				'perfil' 		=> Personal::PROFILE_DOCENTE,
				'keySucursal' 	=> 'idSucursal',
			],

			'docentes-list' => [
				'class' 		=> '\controllers\sucursales\actions\ListPersonalAction',
				'perfil' 		=> Personal::PROFILE_DOCENTE,
				'keySucursal' 	=> 'idSucursal',
			],

			'docentes-toggle-status' => [
				'class' 		=> '\controllers\personal\actions\ToggleStatusAction',
				'key' 			=> 'id',
			],

			'docentes-update' => [
				'class' 		=> '\controllers\sucursales\actions\UpdatePersonalAction',
				'key' 			=> 'id',
				'keySucursal'	=> 'idSucursal',
				'perfil'		=> Personal::PROFILE_DOCENTE,
			],
		];
	}

	public function beforeAction($action)
	{
		if(parent::beforeAction($action) !== true)
			Tools::httpException(403);

		if(Yii::$app->user->identity->isAdmin())
			return true;

		if(!in_array( $action->id, ['view', 'docentes', 'docentes-create', 'personal-delete',  'docentes-add-users', 'docentes-list', 'docentes-update','docentes-toggle-status']) || !Yii::$app->user->identity->isAdminSucursal() )
			Tools::httpException(403);

		else
			return true;
	}

	public function actionIndex()
	{
		$this->view->H1  = Yii::t('app','Sucursales');

		$queryActivo   = Yii::$app->user->identity->querySucursales()->andWhere('sucursal.activo = 1');
		$queryInactivo = Yii::$app->user->identity->querySucursales()->andWhere('sucursal.activo = 0');

		$data = [
			'activos'        => new ActiveDataProvider([
				'query'      => $queryActivo,
				'pagination' 	=> [
					'pageSize' => 20
				],
				'sort' => [
					'defaultOrder'=>[
						'id' => SORT_DESC,
					]
				]
			]),

			'inactivos'        => new ActiveDataProvider([
				'query'      => $queryInactivo,
				'pagination' 	=> [
					'pageSize' => 20
				],
				'sort' => [
					'defaultOrder'=>[
						'id' => SORT_DESC,
					]
				]
			]),
		];


		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "institution";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app','Sucursales')  , 'url' => Url::toRoute([$this->currentController . '/' . $this->defaultAction ])],
		];
		return $this->render('index', $data);
	}

	public function actionCreate()
	{
		$this->model        = new DbModel;
		$this->view->H1     = Yii::t('app','Nueva sucursal');
		$this->view->title  = $this->view->H1 . ' - ' .  Yii::$app->name ;

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "plus";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Sucursales') , 'url' => Url::toRoute([$this->currentController . '/index' ]) ],
			['label' =>  Html::encode($this->view->H1) , 'url' => Url::toRoute([$this->currentController . '/create' ])  ],
		];

        if(Yii::$app->request->isPost)
            return $this->processForm();

		return $this->render('form');
	}

	public function actionView($id)
	{
		$this->model = DbModel::findOne( (int) $id );

		if(is_null($this->model))
			Tools::httpException(404);

		if(!Yii::$app->user->identity->isAdmin() && $this->model->activo == 0)
			Tools::httpException(404);

		$this->view->H1             = Yii::t('app','Sucursales');
		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;

		if(Yii::$app->user->identity->isAdmin())
			$this->view->breadcrumbs[]  = ['label' =>  Yii::t('app','Sucursales')  , 'url' => Url::toRoute([$this->currentController . '/' . $this->defaultAction ])];

		$this->view->breadcrumbs[] = ['label' => Html::encode($this->model->nombre), 'url' => Url::toRoute([$this->currentController . '/' . $this->currentAction , 'id' => $this->model->id]) ];

		$estadistica = [
			'usuarios' => [
				'admin' => (object)[
					'active' => $this->model->db->createCommand('select COUNT_USER_ACTIVE_SUCURSAL(:idSucursal, 2)', [':idSucursal' => $id ])->queryScalar(),
					'total'  => $this->model->db->createCommand('select COUNT_USER_ACTIVE_SUCURSAL(:idSucursal, 2) + COUNT_USER_INACTIVE_SUCURSAL(:idSucursal, 2) ', [':idSucursal' => $id ])->queryScalar(),
	 			],

				'docentes' => (object) [
					'active' => $this->model->db->createCommand('select COUNT_USER_ACTIVE_SUCURSAL(:idSucursal, 3)', [':idSucursal' => $id ])->queryScalar(),
					'total'  => $this->model->db->createCommand('select COUNT_USER_ACTIVE_SUCURSAL(:idSucursal, 3) + COUNT_USER_INACTIVE_SUCURSAL(:idSucursal, 3) ', [':idSucursal' => $id ])->queryScalar(),
	 			],

				'estudiantes' => (object) [
					'active' => $this->model->db->createCommand('select COUNT_USER_ACTIVE_SUCURSAL(:idSucursal, 4)', [':idSucursal' => $id ])->queryScalar(),
					'total'  => $this->model->db->createCommand('select COUNT_USER_ACTIVE_SUCURSAL(:idSucursal, 4) + COUNT_USER_INACTIVE_SUCURSAL(:idSucursal, 4) ', [':idSucursal' => $id ])->queryScalar(),
	 			],
			],
			'cursadas' => [
				'por_iniciar' => $this->model->db->createCommand('select COUNT_CURSADAS_POR_INICIAR(:idSucursal)', [':idSucursal' => $id ])->queryScalar(),
				'activas'     => $this->model->db->createCommand('select COUNT_CURSADAS_ACTIVAS(:idSucursal)', [':idSucursal' => $id ])->queryScalar(),
				'finaliadas'  => $this->model->db->createCommand('select COUNT_CURSADAS_FINALIZADAS(:idSucursal)', [':idSucursal' => $id ])->queryScalar(),
				'canceladas'  => $this->model->db->createCommand('select COUNT_CURSADAS_CANCELADAS(:idSucursal)', [':idSucursal' => $id ])->queryScalar(),
			]
		];

		return $this->render('view', [
			'estadistica' => $estadistica,
		]);
	}

	public function actionUpdate($id)
	{
		$this->model = DbModel::findOne($id);
		if(is_null($this->model))
			Tools::httpException(404);

		$this->view->H1     = Yii::t('app','Actualizar sucursal {nombre}', ['nombre' => $this->model->nombre ]);
		$this->view->title  = $this->view->H1 . ' - ' .  Yii::$app->name ;

		$this->view->title          = $this->view->H1 . ' - ' .  Yii::$app->name ;
		$this->view->iconClass      = "plus";
		$this->view->breadcrumbs    = [
			['label' =>  Yii::t('app', 'Sucursales') , 'url' => Url::toRoute([$this->currentController . '/index' ]) ],
			['label' =>  Html::encode($this->view->H1) ,  'url' => Url::toRoute([ $this->currentController . '/update', 'id' => $this->model->id ]) ],
		];

        if(Yii::$app->request->isPost)
            return $this->processForm();

		return $this->render('form');
	}

    private function processForm()
    {
        if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

        $isNewRecord = $this->model->isNewRecord;

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

        if($isNewRecord)
        {
			$url            = Url::ToRoute([$this->currentController . '/update', 'id' => $this->model->id ]);
			$label          = Yii::t('app', 'Ver ficha de sucursal');
			$link           = sprintf('<a href="%s">%s</a>', $url, $label);
			$messageSuccess = $statusText = Yii::t('app', '<h5 class="margin-v-15">Nueva sucursal <b>{nombre}</b> creada exitosamente!</h5> {link}', ['nombre' => $this->model->nombre , 'link' => $link ]);
        }
        else
        	$messageSuccess = Yii::t('app', '<h5 class="margin-v-15">Sucursal <b>{nombre}</b> modificada exitosamente!</h5>', ['nombre' => $this->model->nombre ]);

        return $this->asJson([
            'status'     => true,
            'statusCode' => 'Acción completada exitosamente!',
            'statusText' => $messageSuccess,
        ]);
    }

    public function actionDelete($id)
    {
        if(!Yii::$app->request->isAjax || !Yii::$app->request->isPost)
			Tools::httpException(400);

    	$model = DbModel::findOne($id);
    	$msnSuccess = Yii::t('app', 'Registro eliminado exitosamente!');
    	$msnError   = Yii::t('app', 'No es posible eliminar él registro seleccionado. Otros datos dependen de él.');

		if(is_null($model))
			Yii::$app->session->setFlash('success', $msnSuccess);

		else{
			try{
				if($model->delete())
					Yii::$app->session->setFlash('success', $msnSuccess);
				else
					Yii::$app->session->setFlash('danger', $msnError  );
			}
			catch(\Exception $e){
				Yii::$app->session->setFlash('danger', $msnError );
			}
		}
    }

    public function actionDocentesAddUsers($idSucursal)
    {
		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		$modelSucursal = DbModel::findOne($idSucursal);
		if(is_null($modelSucursal))
			Tools::httpException(400);

		if(Yii::$app->request->isPost)
		{
			$idUsuario = (int) Yii::$app->request->post('index', 0);

			try{
				Personal::getDb()->createCommand()
					->insert('usuario_sucursal', [
						'id_sucursal' => $idSucursal,
						'id_usuario'  => $idUsuario,
					])->execute();

			}
			catch(\Exception $e){
				//print_r($e->getMessage());
			}
			return;
		}

		$query = Personal::find();
		$query->where('id_perfil = 3 and activo = 1');
		$query->andWhere('id not in (select id_usuario from usuario_sucursal where id_sucursal= :id_sucursal)', [
			':id_sucursal' => $idSucursal
		]);

		$search  = Yii::$app->request->getQueryParam('search', null);

		if(!empty($search))
		{
			$keyWords    = [];
			$numersWords = [];
			$filters     = null;

			foreach(explode(' ', $search) as $key)
			{
				$key = preg_replace('<\s>', '', $key);
				$key = trim($key);

				if(strlen($key)< 1)
					continue;

				if(is_numeric($key))
					array_push($numersWords, $key);
				else
					array_push($keyWords, $key);
			}

			$numersWords = array_unique($numersWords);
			$keyWords    = array_unique($keyWords);

			foreach($numersWords as $item)
			{
				$format  = 'nro_documento like \'%'. $item.'%\'';
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			foreach($keyWords as $item)
			{
				$item    = addslashes($item);
				$format  = sprintf('( nombres like \'%%%s\' or apellidos like \'%%%s\')', $item, $item );
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			if(!empty($filters))
				$query->andWhere($filters);
		}

		$dataProvider = new ActiveDataProvider([
			'query' 		=> $query,
			'pagination' 	=> [
				'pageSize' => 5
			],
			'sort' => [
				'enableMultiSort' => true,
				'defaultOrder' => [
					'nombres'    	=> SORT_ASC,
					'apellidos' 	=> SORT_ASC,
					'nro_documento' => SORT_ASC,
				]
			]
		]);

		$this->view->iconClass  = 'users';
		$this->view->H1			= Yii::t('app' , 'Docentes que no pertenecen a sucursal {sucursal}', [
			'sucursal' => Html::encode($modelSucursal->nombre)
		]);

		return $this->renderAjax('personal/add-usuario-sucursal', [
			'dataProvider' 	=> $dataProvider,
			'sucursal'		=> $modelSucursal,
		]);
    }

    public function actionAdministradoresAddUsers($idSucursal)
    {
		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		$modelSucursal = DbModel::findOne($idSucursal);
		if(is_null($modelSucursal))
			Tools::httpException(400);

		if(Yii::$app->request->isPost)
		{
			$idUsuario = (int) Yii::$app->request->post('index', 0);

			try{
				Personal::getDb()->createCommand()
					->insert('usuario_sucursal', [
						'id_sucursal' => $idSucursal,
						'id_usuario'  => $idUsuario,
					])->execute();

			}
			catch(\Exception $e){
				//print_r($e->getMessage());
			}
			return;
		}

		$query = Personal::find();
		$query->where('id_perfil = 2 and activo = 1');
		$query->andWhere('id not in (select id_usuario from usuario_sucursal where id_sucursal= :id_sucursal)', [
			':id_sucursal' => $idSucursal
		]);

		$search  = Yii::$app->request->getQueryParam('search', null);

		if(!empty($search))
		{
			$keyWords    = [];
			$numersWords = [];
			$filters     = null;

			foreach(explode(' ', $search) as $key)
			{
				$key = preg_replace('<\s>', '', $key);
				$key = trim($key);

				if(strlen($key)< 1)
					continue;

				if(is_numeric($key))
					array_push($numersWords, $key);
				else
					array_push($keyWords, $key);
			}

			$numersWords = array_unique($numersWords);
			$keyWords    = array_unique($keyWords);

			foreach($numersWords as $item)
			{
				$format  = 'nro_documento like \'%'. $item.'%\'';
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			foreach($keyWords as $item)
			{
				$item    = addslashes($item);
				$format  = sprintf('( nombres like \'%%%s\' or apellidos like \'%%%s\')', $item, $item );
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			if(!empty($filters))
				$query->andWhere($filters);
		}

		$dataProvider = new ActiveDataProvider([
			'query' 		=> $query,
			'pagination' 	=> [
				'pageSize' => 5
			],
			'sort' => [
				'enableMultiSort' => true,
				'defaultOrder' => [
					'nombres'    	=> SORT_ASC,
					'apellidos' 	=> SORT_ASC,
					'nro_documento' => SORT_ASC,
				]
			]
		]);

		$this->view->iconClass  = 'users';
		$this->view->H1			= Yii::t('app' , 'Docentes que no pertenecen a sucursal {sucursal}', [
			'sucursal' => Html::encode($modelSucursal->nombre)
		]);

		return $this->renderAjax('personal/add-usuario-sucursal', [
			'dataProvider' 	=> $dataProvider,
			'sucursal'		=> $modelSucursal,
		]);
    }

	public function actionPersonalDelete($id, $idSucursal)
	{
		$model    = Personal::find()->where('id =:id', [':id' => $id])->one();
		$redirect = Yii::$app->request->getQueryParam('redirect', null);

		if(!is_null($model))
		{
			if($model->id_perfil == Personal::PROFILE_ADMIN_SUCURSAL && !Yii::$app->user->identity->isAdmin())
				Tools::httpException(403, Yii::t('app', 'Sin permisos para actualizar este contenido.'));

			$sucursales = array_column($model->getUsuarioSucursals()->select('id_sucursal')->asArray()->all(), 'id_sucursal') ;
			if(!in_array($idSucursal, $sucursales))
				Tools::httpException(404);

			$transaction = $model::getDb()->beginTransaction();
			try{

				$numRows = $model::getDb()->createCommand()
					->delete('usuario_sucursal', 'id_sucursal = :id_sucursal and id_usuario =:id_usuario', [
						':id_sucursal' => $idSucursal,
						':id_usuario'  => $model->id,
				])->execute();
				if($numRows > 0)
				{
					$transaction->commit();
					Yii::$app->session->setFlash('success',  Yii::t('app', 'Registro eliminado de sucursal!') );
				}
				else
					$transaction->rollBack();
			}
			catch(\Exception $e){
				Yii::$app->session->setFlash('danger', Yii::t('app', 'No es posible eliminar él registro seleccionado de la sucursal. Otros datos dependen de él.') );
			}
		}

		if(!Yii::$app->request->isAjax)
		{
			if(is_null($redirect))
				return  $this->goBack();
			else
				return $this->redirect($redirect);
		}
	}
}
