<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use base\helpers\mailer\SendMail;
use base\helpers\Queries;
use base\helpers\Tools;

class TestController extends Controller
{
    /**
     * Test send mail:
     * @param string $email email de prueba
     * @param string $username nombre de usuario
     * @return int Exit code
     */
    public function actionSendMail($email = 'salas.flavio@gmail.com', $username = 'Flavio E. Salas M.')
    {
        var_dump(SendMail::test($email, $username));
        return ExitCode::OK;
    }

    public function actionQueries()
    {
        echo Yii::$app->queries->now();
        echo PHP_EOL;
        echo Queries::instance()->now();
    }

    public function actionListDates($dateInit = '2000-01-01', $nroDias=20, $diasXsemana = '1,2' )
    {
        $diasXsemana = explode(',', $diasXsemana);

        $list = Tools::datesFromDaysOnWeek( new \Datetime($dateInit), $nroDias,  $diasXsemana, ['2000-01-01', '2000-01-24'] /*['2000-01-03', '2000-01-20']*/ );
        print_r($list);
    }


    public function actionX()
    {
        $cursada          = \base\modules\cursadas\models\FechaInicio::findOne(1);
        $cursadaHorario   = \base\modules\cursadas\models\CursadaHorario::findOne(1);
        $diasActivos      = $cursadaHorario->getDaysList();
        $fechasExcluidas  = explode(',', $cursadaHorario->fechas_excluidas);

        $indexInitEval = 0;
        $indexEndEval  = 0;

        foreach (Tools::datesFromDaysOnWeek( new \Datetime($cursada->oldAttributes['fecha_inicio']), $cursada->cantidad_clases, $diasActivos, $fechasExcluidas )  as $key => $value)
        {
            if($cursada->fecha_inicio_evaluacion == $value)
                $indexInitEval = $key;

            if($cursada->fecha_fin_evaluacion == $value)
                $indexEndEval = $key;
        }

        $cursada->fecha_inicio = '2020-01-15';


        $listFechas = Tools::datesFromDaysOnWeek( new \Datetime($cursada->fecha_inicio),  $cursada->cantidad_clases, $diasActivos, $fechasExcluidas);
        $cursada->fecha_inicio              = $listFechas[0];
        $cursada->fecha_fin                 = end($listFechas);
        $cursada->fecha_inicio_evaluacion   = $listFechas[$indexInitEval];
        $cursada->fecha_fin_evaluacion      = $listFechas[$indexEndEval];

        print_r($cursada->getAttributes(['fecha_inicio', 'fecha_fin', 'fecha_inicio_evaluacion', 'fecha_fin_evaluacion']));




//        print_r($listFechas);




        /*
            print_r( $diaInicioEvaluacion);
            echo PHP_EOL;
            print_r( $diaFinEvaluacion);
        */

    }




    public function __destruct()
    {
        echo PHP_EOL;
    }
}
