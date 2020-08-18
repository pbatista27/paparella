<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
	use base\widgets\faicons\Fa;

    $module	 = '/' . $this->context->module->id;
    $action  = $this->context->action->id;
?>

<div class="list-group">
<?php
	//curso:
	$text   = Fa::icon('angle-left')->fw();
	$text  .= Yii::t('app', 'Datos basicos');
	$link   = Url::toRoute([ $module . '/create/index']);
	$active = ($action == 'index') ? ' active' : false;
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0 ]);

	//curso programacion:
	$text   = Fa::icon('angle-left')->fw();
	$text  .= Yii::t('app', 'Programación');
	$link   = Url::toRoute([ $module . '/create/programacion']);
	$active = ($action == 'programacion') ? ' active' : false;
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0  ]);

	//curso material programa:
	$text    = Fa::icon('angle-left')->fw();
	$text   .= Yii::t('app', 'Material Programa');
	$active  = ($action == 'material-programa') ? ' active' : false;
	$link    = Url::toRoute([ $module . '/create/material-programa']);
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0  ]);

	//curso material programa:
	$text    = Fa::icon('angle-left')->fw();
	$text   .= Yii::t('app', 'Material para Docentes');
	$active  = ($action == 'material-docentes') ? ' active' : false;
	$link    = Url::toRoute([ $module . '/create/material-docentes']);
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0  ]);

	$text    = Fa::icon('angle-left')->fw();
	$text   .= Yii::t('app', 'Material para Estudiantes');
	$active  = ($action == 'material-estudiantes') ? ' active' : false;
	$link    = Url::toRoute([ $module . '/create/material-estudiantes']);
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0  ]);

	//Exámenes:
	$text    = Fa::icon('angle-left')->fw();
	$text   .= Yii::t('app', 'Exámenes');
	$active  = ($action == 'examenes') ? ' active' : false;
	$link    = Url::toRoute([ $module . '/create/examenes']);
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0  ]);

	//Sucursales-activas:
	$text    = Fa::icon('angle-left')->fw();
	$text   .= Yii::t('app', 'Sucursales activas');
	$active  = ($action == 'sucursales-activas') ? ' active' : false;
	$link    = Url::toRoute([ $module . '/create/sucursales-activas']);
	echo Html::a($text, $link, ['class' => 'list-group-item' . $active , 'data-pjax' => $active ? 1 : 0  ]);
?>
</div>
