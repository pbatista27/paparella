<?php
namespace base\modules\cursadas\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\CursoSucursal;
use app\models\Curso;
use base\helpers\Tools;

class Create extends Cursada
{
	public $sucursal;
	public $curso;
	public $dia_inicio_evaluacion;
	public $dia_fin_evaluacion;

	public function scenarios()
	{
		return [
			'create_datos_basicos'  => ['id_curso_sucursal', 'fecha_inicio', 'periodo', 'seccion', 'nro_cupos'],
			'evaluacion'   			=> ['examen', 'dia_inicio_evaluacion', 'dia_fin_evaluacion'],
		];
	}

	public function calcualteAttributesOnCreate()
	{
		if($this->scenario != 'create_datos_basicos')
			return;

		try{
			$curso = $this->getCurso()->one();
			$this->cantidad_meses   = $curso->cantidad_meses;
			$this->cantidad_clases  = $curso->cantidad_clases;
			$this->precio_cuota     = $curso->precio_cuota;
			$this->precio_matricula = $curso->precio_matricula;
			$this->nro_disponibles  = $this->nro_cupos;
			$this->status           = 0;
		}
		catch(\Exception $e)
		{
			$this->validate(['id_curso_sucursal']);
		}
	}

	public function rules()
	{
		return [
			// scenario datos_basicos:
			[['id_curso_sucursal', 'fecha_inicio', 'periodo', 'seccion', 'nro_cupos'], 'required' ],
			[['id_curso_sucursal'] , 'in', 'range' => array_keys( $this->getMapActiveCS($this->sucursal) )],
			[['periodo'], 'unqCursoSucursal'],
			[['nro_cupos'], 'integer', 'min' => 5 , 'max' => 100],
			[['fecha_inicio'], 'date', 'min' => Tools::getNextDay(), 'format'=> 'php:Y-m-d' ],
			// scenario evaluacion:
			[['examen'] , 'string'],
			[['examen', 'dia_inicio_evaluacion', 'dia_fin_evaluacion'] , 'required'],
			[['dia_inicio_evaluacion'], 'integer', 'min' => 1 , 'max' => $this->cantidad_clases ],
			[['dia_fin_evaluacion'],    'integer', 'min' => 1 , 'max' => $this->cantidad_clases ],
			[['dia_fin_evaluacion'],    'compare', 'operator' =>'>=' , 'compareAttribute' => 'dia_inicio_evaluacion'],
        ];
	}
}
