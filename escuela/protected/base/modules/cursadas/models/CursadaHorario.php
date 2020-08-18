<?php
namespace base\modules\cursadas\models;

use Yii;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\CursoSucursal;

class CursadaHorario extends \app\models\CursadaHorario
{
    public $curso;

	public $dia1 = 1;
	public $dia2 = 2;
	public $dia3 = 3;
	public $dia4 = 4;
	public $dia5 = 5;
	public $dia6 = 6;
	public $dia7 = 7;

	const NRO_DIAS = [
        1 =>'Lunes',
        2 =>'Martes',
        3 =>'Miércoles',
        4 =>'Jueves',
        5 =>'Viernes',
        6 =>'Sabado',
        7 =>'Domingo',
	];

    public function rules()
    {


    	$rules = [
            [['fechas_excluidas'] , 'string'],
            //[['d1_aula'], 'required', 'enableClientValidation' => false],
            //[['id_cursada'], 'required'],
            //[['id_cursada'], 'integer'],
			//[['id_cursada'], 'unique'],
			//[['id_cursada'], 'exist', 'skipOnError' => true, 'targetClass' => Cursada::className(), 'targetAttribute' => ['id_cursada' => 'id']],
    	];

    	for($i=1; $i<8; $i++)
    	{
    		$desdeAttr = 'd'.$i.'_desde';
    		$hastaAttr = 'd'.$i.'_hasta';
    		$aulaAttr  = 'd'.$i.'_aula';

    		// time format:
			array_push($rules, [
				[$desdeAttr], 'time', 'format'=> 'php:H:i', 'min'=> '07:00', 'max' => '21:00',
			]);

			array_push($rules, [
				[$hastaAttr], 'time', 'format'=> 'php:H:i', 'min'=> '07:00', 'max' => '21:45',
			]);
            // required on defined $hastaAttr
            array_push($rules, [
                [$hastaAttr], 'required', 'when'=> function($model, $desdeAttr){

                    if(!empty($this->{$model->$desdeAttr}))
                        return true;
                },
                'whenClient' => 'function(attribute, value){
                    var target = $("#'. Html::getInputId($this, $desdeAttr)  .'");

                    try{
                        if(target.val().length > 0)
                            return true;
                    }catch(e){
                        console.log(e);
                    }

                    return false;
                }',
            ]);

            // required on defined $hastaAttr
            array_push($rules, [
                [$desdeAttr], 'required', 'when'=> function($model, $desdeAttr){

                    if(!empty($this->{$model->$desdeAttr}))
                        return true;
                },
                'whenClient' => 'function(attribute, value){
                   var target = $("#'. Html::getInputId($this, $hastaAttr)  .'");

                    try{
                        if(target.val().length > 0)
                            return true;
                    }catch(e){
                        console.log(e);
                    }

                    return false;
                }',
            ]);

            // check aula
			array_push($rules, [
				[$aulaAttr], 'string', 'min'=>1, 'max' => 20,
			]);

            // check min-max $desdeAttr - $hastaAttr
            array_push($rules, [
                [$desdeAttr, $hastaAttr], 'CompareRangeTime',
            ]);
            // check por lo menos una fecha:
    	}

        return $rules;
    }

    public function CompareRangeTime( $attribute, $params , $validator)
    {
    	$desdeAttr = $validator->attributes[0];
    	$hastaAttr = $validator->attributes[1];

        $init  = $this->{$validator->attributes[0]};
        $end   = $this->{$validator->attributes[1]};

        if(empty($init) || empty($end))
            return;

        if(strtotime($end) <= strtotime($init) )
        {
            $error = Yii::t('app', '{attr2} debe ser mayor a {attr1}', [
                'attr1' => $this->getAttributeLabel($desdeAttr),
                'attr2' => $this->getAttributeLabel($hastaAttr),
            ]);

            $this->addError($hastaAttr, $error);
        }
    }

    public function beforeValidate()
    {
        $hasElements = false;
        for($i=1; $i<8; $i++)
        {
            $desdeAttr = 'd'.$i.'_desde';
            $hastaAttr = 'd'.$i.'_hasta';

            if(empty($this->$desdeAttr) && empty($this->$desdeAttr))
                continue;
            else{
              $hasElements = true;
              break;
            }
        }

        if($hasElements == false)
        {
            for($i=1; $i<8; $i++)
            {
                $desdeAttr = 'd'.$i.'_desde';
                $hastaAttr = 'd'.$i.'_hasta';
                $error = Yii::t('app', 'Es necesario definir por lo menos un día a la semana');
                $this->addError($desdeAttr, $error);
                $this->addError($hastaAttr, $error);

            }
            return false;
        }

        return parent::beforeValidate();
    }

	public function attributeLabels()
    {
        return [
			'dia1'		=> Yii::t('app', 'Lunes'),
			'dia2'		=> Yii::t('app', 'Martes'),
			'dia3'		=> Yii::t('app', 'Miércoles'),
			'dia4'		=> Yii::t('app', 'Jueves'),
			'dia5'		=> Yii::t('app', 'Viernes'),
			'dia6'		=> Yii::t('app', 'Sabados'),
			'dia7'		=> Yii::t('app', 'Domingos'),

            'd1_desde' => Yii::t('app', 'Hora de inicio'),
            'd1_hasta' => Yii::t('app', 'Hora de fin'),
            'd1_aula'  => Yii::t('app', 'Nro. aula (opcional)'),

            'd2_desde' => Yii::t('app', 'Hora de inicio'),
            'd2_hasta' => Yii::t('app', 'Hora de fin'),
            'd2_aula'  => Yii::t('app', 'Nro. aula (opcional)'),

            'd3_desde' => Yii::t('app', 'Miércoles inicio'),
            'd3_hasta' => Yii::t('app', 'Miércoles fin'),
            'd3_aula'  => Yii::t('app', 'Nro. aula (opcional)'),

            'd4_desde' => Yii::t('app', 'Hora de inicio'),
            'd4_hasta' => Yii::t('app', 'Hora de fin'),
            'd4_aula'  => Yii::t('app', 'Nro. aula (opcional)'),

            'd5_desde' => Yii::t('app', 'Hora de inicio'),
            'd5_hasta' => Yii::t('app', 'Hora de fin'),
            'd5_aula'  => Yii::t('app', 'Nro. aula (opcional)'),

            'd6_desde' => Yii::t('app', 'Hora de inicio'),
            'd6_hasta' => Yii::t('app', 'Hora de fin'),
            'd6_aula'  => Yii::t('app', 'Nro. aula (opcional)'),


            'd7_desde' => Yii::t('app', 'Hora de inicio'),
            'd7_hasta' => Yii::t('app', 'Hora de fin'),
            'd7_aula'  => Yii::t('app', 'Nro. aula (opcional)'),

            'fechas_excluidas' => Yii::t('app', 'Feriados y otras fechas excluidas'),
		];
	}


    public function getDaysList()
    {
        $list = [];
        for($i=1; $i<8; $i++)
        {
            $desdeAttr = 'd'.$i.'_desde';
            $hastaAttr = 'd'.$i.'_hasta';

            if(!empty($this->{$desdeAttr}) && !empty($this->{$hastaAttr}))
                array_push($list, $i);
        }

        return $list;
    }

    public function getHorariosToString()
    {
        $listDays = $this->getDaysList();
        $dias = null;

        foreach($this->getDaysList() as $key => $i)
        {
            $dia   = static::NRO_DIAS[$i];
            $desde = Yii::$app->formatter->asTime( $this->{'d'.$i.'_desde'}, 'short');
            $hasta = Yii::$app->formatter->asTime( $this->{'d'.$i.'_hasta'}, 'short');
            $aula  = $this->{'d'.$i.'_aula'};


            if(empty($aula))
                $dias.= Yii::t('app', '{0} {1} - {2}', [$dia , $desde, $hasta] );
            else
                $dias.= Yii::t('app', '{0} {1} - {2} , Aula {3}', [$dia , $desde, $hasta , $aula]) . '<br>';
        }

       return $dias;
    }
}

