<?php
namespace base\modules\cursadas\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\CursoSucursal;
use app\models\Curso;

class Cursada extends \app\models\Cursada
{
	public function getCurso()
	{
		$query = Curso::find();
		$query->join('INNER JOIN', 'curso_sucursal as cs', 'cs.id_curso = curso.id');
		$query->where('cs.id =:id', [':id' => $this->id_curso_sucursal]);
		return $query;
	}

	public function unqCursoSucursal($attribute)
	{
		$model = static::find()->where('id_curso_sucursal = :id_curso_sucursal and periodo=:periodo and seccion=:seccion', [
			':id_curso_sucursal' => $this->id_curso_sucursal,
			':periodo' 			 => $this->periodo,
			':seccion'			 => $this->seccion,
		])->one();

		if(is_null($model))
			return;

		if($this->isNewRecord || $this->id != $model->id)
		{
			$this->addError('id_curso_sucursal' , '');
			$this->addError('seccion' , '');
			$this->addError('periodo' , Yii::t('app', 'Ya existe una cursada con el curso , periodo electivo y seccion para esta sucursal'));
		}
	}

	public function getMapExamen($idCursoSucursal)
	{
		$SQL = "
			SELECT cc.archivo as id, nombre as label
			FROM curso_contenido as cc
			INNER JOIN curso_sucursal AS cs ON cs.id_curso = cc.id_curso
			where id_tipo_contenido = 4
			and cs.id = :idCursoSucursal
			order by label asc ";

		$map = [];
		foreach( $this->db->createCommand($SQL, [':idCursoSucursal' => $idCursoSucursal])->queryAll(\PDO::FETCH_OBJ) as $item)
			$map[$item->id] = $item->label;

		return $map;
	}

	public function getMapActiveCS($idSucursal)
	{
		$SQL = "
			SELECT cs.id AS id, CONCAT( CONCAT(UPPER(LEFT(c.nombre, 1)), LOWER(SUBSTRING(c.nombre, 2))) ) AS label FROM curso AS c
			INNER JOIN curso_sucursal AS cs ON cs.id_curso = c.id
			INNER JOIN sucursal AS s ON s.id = cs.id_sucursal
			WHERE c.activo = 1 AND s.activo = 1 AND s.id = :idSucursal
			ORDER BY label ASC
		";

		$map = [];
		foreach( $this->db->createCommand($SQL, [':idSucursal' => $idSucursal])->queryAll(\PDO::FETCH_OBJ) as $item)
		{
			$map[$item->id] = $item->label;
		}

		return $map;
	}

	public function getMapCursoSucursal($idSucursal = null, $status = null)
	{
		$SQL = "
		SELECT DISTINCT
			cs.id as id,
			CONCAT( CONCAT(UPPER(LEFT(c.nombre, 1)), LOWER(SUBSTRING(c.nombre, 2))) ) as label

		FROM cursada
			INNER JOIN curso_sucursal AS cs ON cs.id = cursada.id_curso_sucursal
			INNER JOIN curso AS c ON c.id = cs.id_curso
			WHERE 	id_sucursal = :idSucursal
			AND 	cursada.status = :status
			ORDER BY label asc
		";

		$map = [];
		foreach( $this->db->createCommand($SQL, [':idSucursal' => $idSucursal, ':status' => $status])->queryAll(\PDO::FETCH_OBJ) as $item)
		{
			$map[$item->id] = $item->label;
		}

		return $map;
	}

	public function getMapNombreCursada($idSucursal = null, $status = null)
	{
		$SQL = "
		SELECT DISTINCT
			cursada.id as id,
			CONCAT(cursada.periodo, ' - ', cursada.seccion ) as label

		FROM cursada
			INNER JOIN curso_sucursal AS cs ON cs.id = cursada.id_curso_sucursal
			INNER JOIN curso AS c ON c.id = cs.id_curso
			WHERE 	id_sucursal = :idSucursal
			AND 	cursada.status = :status
			ORDER BY label asc
		";

		$map = [];
		foreach( $this->db->createCommand($SQL, [':idSucursal' => $idSucursal, ':status' => $status])->queryAll(\PDO::FETCH_OBJ) as $item)
		{
			$map[$item->id] = $item->label;
		}

		return $map;
	}

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_curso_sucursal' => Yii::t('app', 'Curso'),
            'id_examen' => Yii::t('app', 'Evaluación'),
            'periodo' => Yii::t('app', 'Período electivo'),
            'seccion' => Yii::t('app', 'Sección'),
            'horario' => Yii::t('app', 'Horario'),
            'cantidad_meses' => Yii::t('app', 'Cantidad de meses'),
            'cantidad_clases' => Yii::t('app', 'Cantidad de clases'),
            'precio_cuota' => Yii::t('app', 'Precio de cuotas'),
            'precio_matricula' => Yii::t('app', 'Precio de matricula'),
            'nro_cupos' => Yii::t('app', 'Nro. cupos totales'),
            'nro_disponibles' => Yii::t('app', 'Nro. cupos dis.'),
            'examen' => Yii::t('app', 'Examen'),
            'fecha_inicio' => Yii::t('app', 'Fecha de inicio'),
            'fecha_inicio_evaluacion' => Yii::t('app', 'Fecha de evaluacion'),
            'fecha_fin_evaluacion' => Yii::t('app', 'Fecha maxima para entrega de evaluación'),
            'fecha_fin' => Yii::t('app', 'Fecha de finalización'),
            'status' => Yii::t('app', '0 no inciada | 1 inciada (en curso) | 2 finalizada | 3 cancelada'),
        ];
    }

	public function getNombreCurso()
	{
		if($this->isNewRecord)
			return null;

        return ucfirst(strtolower($this->getCursoSucursal()->one()->getCurso()->one()->nombre)) ;
	}

	public function getPeriodoSec()
	{
		if($this->isNewRecord)
			return null;

		return $this->periodo . ' - '. $this->seccion;
	}

	public function addCommonFilters(&$query)
	{
		$this->id_curso_sucursal = is_numeric($this->id_curso_sucursal)     ? $this->id_curso_sucursal  : null;
		$this->nro_cupos         = is_numeric($this->nro_cupos)       		? $this->nro_cupos       	: null;
		$this->nro_disponibles   = is_numeric($this->nro_disponibles) 		? $this->nro_disponibles 	: null;

		$query->andFilterWhere([
			'cursada.id' 				=> $this->id,
            'cursada.id_curso_sucursal' => $this->id_curso_sucursal,
            'cursada.nro_cupos' 		=> $this->nro_cupos,
            'cursada.nro_disponibles' 	=> $this->nro_disponibles,
		]);

		$query->andFilterWhere(['like', 'horario', $this->horario]);
	}

	public function search($idSucursal, $params = [])
	{
		$idSucursal = (int) $idSucursal;
		$query      = static::find();
		$params     = isset($params[$this->formName()]) ? $params[$this->formName()] : [];

		$this->setAttributes($params, false);
		$this->addCommonFilters($query);

		$query->join('INNER JOIN', 'curso_sucursal as cs', 'cursada.id_curso_sucursal = cs.id');
		$query->join('INNER JOIN', 'sucursal  as s', 'cs.id_sucursal = s.id');
		$query->andWhere('s.id = :sID', [':sID' => $idSucursal] );

		return  new ActiveDataProvider([
			'query' => $query,
			'pagination' 	=> [
				'pageSize' => 20
			],
			'sort' => [
				'defaultOrder'=>[
					'id' => SORT_DESC,
				]
			]
		]);
	}
}
