<?php
namespace base\modules\cursadas\models;

use Yii;
use base\helpers\Tools;

class FechaInicio extends \app\models\Cursada
{
	public function scenarios()
	{
		return [
			'default' => ['fecha_inicio'],
		];
	}

	public function rules()
	{
		return [
			[['fecha_inicio'], 'date', 'min' => Tools::getNextDay(), 'format'=> 'php:Y-m-d' ],
			[['fecha_inicio'], 'required'],
			[['fecha_inicio'], 'checkStatusCursada'],
		];
	}

	public function checkStatusCursada()
	{
		switch($this->status)
		{
			case 3:
				$msnError = Yii::t('app', 'No puede modificar la fecha de inicio para cursadas canceladas');
				break;

			case 2:
				$msnError = Yii::t('app', 'No puede modificar la fecha de inicio para cursadas finalizadas');
				break;

			case 1:
				$msnError = Yii::t('app', 'No puede modificar la fecha de inicio para cursadas en curso');
				break;
		}

		if(isset($msnError))
			$this->addError('fecha_inicio', $msnError);
	}


	public function save($runValidation = true, $attributeNames = NULL)
	{
		if($this->isNewRecord)
			return false;

		if($this->validate() == false)
			return false;

		$cursadaHorario   = CursadaHorario::findOne($this->id);
		$diasActivos      = $cursadaHorario->getDaysList();
		$fechasExcluidas  = explode(',', $cursadaHorario->fechas_excluidas);

        $indexInitEval = 0;
        $indexEndEval  = 0;

        foreach (Tools::datesFromDaysOnWeek( new \Datetime($this->oldAttributes['fecha_inicio']), $this->cantidad_clases, $diasActivos, $fechasExcluidas )  as $key => $value)
        {
            if($this->fecha_inicio_evaluacion == $value)
                $indexInitEval = $key;

            if($this->fecha_fin_evaluacion == $value)
                $indexEndEval = $key;
        }


        $listFechas = Tools::datesFromDaysOnWeek( new \Datetime($this->fecha_inicio),  $this->cantidad_clases, $diasActivos, $fechasExcluidas);

        $this->fecha_inicio              = $listFechas[0];
        $this->fecha_fin                 = end($listFechas);
        $this->fecha_inicio_evaluacion   = $listFechas[$indexInitEval];
        $this->fecha_fin_evaluacion      = $listFechas[$indexEndEval];

        return parent::save(false, ['fecha_inicio', 'fecha_fin', 'fecha_inicio_evaluacion', 'fecha_fin_evaluacion']);
	}
}
