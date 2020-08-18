<?php
namespace base\modules\cursadas\controllers;

use yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use base\helpers\Tools;
use app\models\Cursada;
use app\models\CursadaDocente;
use controllers\personal\models\SearchModel as PersonalSearch;

class DocentesController extends \base\Controller
{
	public $model;
	public $dataProvider;
	public $modelCursada;

	protected function baseQuery()
	{
		$query   = $this->model::find();
		$query->join('INNER JOIN', 'usuario_sucursal as us', 'us.id_usuario = usuario.id');
		$query->join('INNER JOIN', 'sucursal as s', 's.id = us.id_sucursal');
		$query->join('INNER JOIN', 'curso_sucursal as cs', 'cs.id_sucursal = s.id');
		$query->join('INNER JOIN', 'cursada as cur', 'cur.id_curso_sucursal = cs.id');
		$query->andWhere('cur.id =:cursada', [':cursada' => 1]);
		$query->andWhere('usuario.activo    = 1');
		$query->andWhere('usuario.id_perfil = 3');

		return $query;
	}

	public function init()
	{
		parent::init();

		$this->modelCursada = Cursada::find()->where('id = :idCursada', [':idCursada' => Yii::$app->request->get('idCursada')])->one();

		if(is_null($this->modelCursada))
			Tools::httpException(404);
	}

	public function actionIndex($idCursada)
	{
		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		$this->view->H1         = Yii::t('app', 'Cursada docentes');
		$this->view->iconClass  = 'users';

		return $this->renderAjax('index');
	}

	public function actionAdd($idCursada)
	{
		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		if(Yii::$app->request->isPost)
		{
			$model = new CursadaDocente([
				'id_docente' => Yii::$app->request->post('index'),
				'id_cursada' => $idCursada
			]);
			$model->save();
		}

		$this->model = new PersonalSearch();
		$this->model->load(Yii::$app->request->queryParams);

		$query = $this->baseQuery();
		$query->andWhere('usuario.id not in ( select cd.id_docente from cursada_docente as cd where cd.id_cursada =:cursada2 )', [
			':cursada2' => $idCursada
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
				$format  = 'usuario.nro_documento like \'%'. $item.'%\'';
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			foreach($keyWords as $item)
			{
				$item    = addslashes($item);
				$format  = sprintf('( usuario.nombres like \'%%%s\' or usuario.apellidos like \'%%%s\')', $item, $item );
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			if(!empty($filters))
				$query->andWhere($filters);
		}

		$this->dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 5,
			],
			'sort' => [
				'defaultOrder'=> [
					'id' => SORT_DESC,
				]
			],
		]);

		$this->view->H1         = Yii::t('app', 'Cursada agregar docentes');
		$this->view->iconClass  = 'plus';
		return $this->renderAjax('modal-gridview-add');
	}

	public function actionRm($idCursada)
	{
		if(!Yii::$app->request->isAjax)
			Tools::httpException(400);

		if(Yii::$app->request->isPost)
		{
			$model = CursadaDocente::find()->where('id_docente=:docente and id_cursada=:cursada', [
				':docente' => Yii::$app->request->post('index'),
				':cursada' => $idCursada,
			])->one();

			if(!is_null($model))
				$model->delete();

			exit;
		}

		$this->model = new PersonalSearch();
		$this->model->load(Yii::$app->request->queryParams);

		$query = $this->baseQuery();
		$query->andWhere('usuario.id in ( select cd.id_docente from cursada_docente as cd where cd.id_cursada =:cursada2 )', [
			':cursada2' => $idCursada
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
				$format  = 'usuario.nro_documento like \'%'. $item.'%\'';
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			foreach($keyWords as $item)
			{
				$item    = addslashes($item);
				$format  = sprintf('( usuario.nombres like \'%%%s\' or usuario.apellidos like \'%%%s\')', $item, $item );
				$filters.= is_null($filters) ? $format : ' or ' . $format;
			}

			if(!empty($filters))
				$query->andWhere($filters);
		}

		$this->dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 5,
			],
			'sort' => [
				'defaultOrder'=> [
					'id' => SORT_DESC,
				]
			],
		]);

		$this->view->H1         = Yii::t('app', 'Cursada eliminar docentes');
		$this->view->iconClass  = 'times';
		return $this->renderAjax('modal-gridview-delete');
	}
}
