<?php
namespace base\helpers;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use base\widgets\faicons\Fa;
use yii\web\HttpException;

class Tools extends \yii\base\BaseObject
{
    public static function embeberUlrYoutube($video, $autoplay = true)
    {
    	$autoplay = ($autoplay === true) ? '?autoplay=1' : null;
        $cabeza   = 'https://www.youtube.com/embed/';
        $contar   = strlen($video);
        $pie      = substr($video,32,$contar);
        $nuevaUrl = $cabeza. $pie . $autoplay;
        return $nuevaUrl;
    }

	public static function arrayKeywords($q)
	{
		$q = str_replace( ["\r\n", "\r", "\n", "\t"], '', $q);
		$q = preg_replace('<\s{2,}>', ' ', $q);
		$q = explode(' ', $q);
		$q = array_unique($q);
		return $q;
	}

    /*
        @todo pasar a una clase que exitenda de ActionColumn
    */
    public static function  configColumnInactivate($conf = [])
    {
        return [
            'class'    => 'yii\grid\ActionColumn',
            'header'   => Yii::t('app', 'Inhabilitar'),
            'visible'  => (isset($conf["visible"]) && $conf["visible"] == true) ? true : false,
            'template' => '{btn}',
            'contentOptions' => ['style' => 'width: 70px', 'class' => 'text-center'],
            'buttons' => [
                'btn' => function($url, $model, $key){
                    $link = Url::toRoute([Yii::$app->controller->currentController .'/toggle-status', 'id' => $key ]);
                    $text = Fa::icon('times')->fw();
                    return Html::a($text, $link, [
                        'title'                 => Yii::t('app', 'Inhabilitar registro') ,
                        'class'                 => 'text-danger',
                        'data-pjax'             => 0,
                        'data-title-confirm'    => Yii::t('app', 'Inhabilitar registro'),
                        'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea inhabilitar este registro?'),
                        'data-runtime'          => 'ajax-confirm',
                        'data-label-btn-cancel' => Yii::t('yii', 'No'),
                        'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                        'data-icon-class'       => 'fa fa-times',
                        'data-pjax-target'      => '#' . Yii::$app->controller->pjaxId,
                    ]);
                },
            ],
        ];
    }

    /*
        @todo pasar a una clase que exitenda de ActionColumn
    */
    public static function  configColumnActivate($conf = [])
    {
        return [
            'class'    => 'yii\grid\ActionColumn',
            'header'   => Yii::t('app', 'Habilitar'),
            'visible'  => (isset($conf["visible"]) && $conf["visible"] == true) ? true : false,
            'template' => '{btn}',
            'contentOptions' => ['style' => 'width: 70px', 'class' => 'text-center'],
            'buttons' => [
                'btn' => function($url, $model, $key){
                    $link = Url::toRoute([Yii::$app->controller->currentController .'/toggle-status', 'id' => $key ]);
                    $text = Fa::icon('check')->fw();
                    return Html::a($text, $link, [
                        'title'                 => Yii::t('app', 'Habilitar registro') ,
                        'class'                 => 'text-success',
                        'data-pjax'             => 0,
                        'data-title-confirm'    => Yii::t('app', 'Habilitar registro'),
                        'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea habilitar este registro?'),
                        'data-runtime'          => 'ajax-confirm',
                        'data-label-btn-cancel' => Yii::t('yii', 'No'),
                        'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                        'data-icon-class'       => 'fa fa-check',
                        'data-pjax-target'      => '#' . Yii::$app->controller->pjaxId,
                    ]);
                },
            ],
        ];
    }

    public static function httpException($codeError, $messageError = null)
    {
        $list = Yii::$app->params['httpErrors'];


        if(!isset($list[$codeError]))
        {
            $messageError = null;
            $codeError    = 500;
        }

        $messageError = (empty($messageError)) ? $list[$codeError] : $messageError;
        throw new HttpException( $codeError , $messageError);
    }

    public static function getNextDay($date = null)
    {
        $now = new \Datetime($date);
        $now->add(new \DateInterval('P1D'));
        return $now->format('Y-m-d');
    }

    public static function datesFromDaysOnWeek(\Datetime $objDateTime, int $numAddDays, array $listDaysOfWeek, array $datesExclude = [])
    {
        $results        = [];
        $listDaysOfWeek = array_intersect($listDaysOfWeek, range(0,6) );
        sort($listDaysOfWeek);

        if(empty($listDaysOfWeek) || $numAddDays < 1)
            return $results;

        while ( $numAddDays > 0)
        {
            foreach($listDaysOfWeek as $numDay)
            {
                $infoDate   = (object) getdate( $objDateTime->getTimestamp() );
                $dateTarget = $objDateTime->format('Y-m-d');

                if(($numDay != $infoDate->wday) || (in_array($dateTarget,  $datesExclude )) )
                    continue;

                array_push($results, $dateTarget );
                $numAddDays--;
            }

            $objDateTime->add(new \DateInterval('P1D'));
        }

        return $results;
    }
}

