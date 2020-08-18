<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use base\widgets\dashboard\BoxNotification;
	use base\widgets\faicons\Fa;
	use yii\widgets\Pjax;

	Pjax::begin([
		'id'                => $this->context->pjaxId,
		'enablePushState'   => false,
	]);
?>

<div class="row" id="<?= $this->context->pjaxId ?>">
	<?php
		$link = Url::toRoute([ $this->context->currentModule . '/sucursales/update' , 'id' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('edit'),
			'headTitle' 	=> $this->context->model->nombre,
			'footerTitle' 	=> $this->context->model->activo ? Yii::t('app', 'Activa') : Yii::t('app', 'Inactiva'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin()),
			'count'			=> '',
			'link'			=> [ $link, ['data-pjax'=> 0 ] ]
		]);

		// Administradores
		$link = Url::toRoute([ $this->context->currentModule . '/sucursales/administradores' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('star'),
			'headTitle' 	=> Yii::t('app', 'Administradores'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin()),
			'count' 		=> $estadistica['usuarios']['admin'],
			'link' 			=> [ $link, ['data-role'=>'open-modal', 'data-pjax'=> 0 ] ]
		]);

		// Docentes
		$link = Url::toRoute([ $this->context->currentModule . '/sucursales/docentes' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('users'),
			'headTitle' 	=> Yii::t('app', 'Docentes'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			'count' 		=> $estadistica['usuarios']['docentes'],
			'link'			=> [ $link, ['data-role'=>'open-modal', 'data-pjax'=> 0 ] ]
		]);

		// Estudiantes
		$link = Url::toRoute([ $this->context->currentModule . '/estudiantes/index' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('graduation-cap'),
			'headTitle' 	=> Yii::t('app', 'Estudiantes'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			'count' 		=> $estadistica['usuarios']['estudiantes'],
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		//Cursadas
		$link = Url::toRoute(['/cursadas/default/por-iniciar' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('file-text-o'),
			'headTitle' 	=> Yii::t('app', 'Cursadas por iniciar'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			'count'			=> $estadistica['cursadas']['por_iniciar'],
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		//Cursadas
		$link = Url::toRoute(['/cursadas/default/en-curso' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('file-text-o'),
			'headTitle' 	=> Yii::t('app', 'Cursadas en curso'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			'count'			=> $estadistica['cursadas']['activas'],
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		$link = Url::toRoute(['/cursadas/default/finalizadas' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('file-text-o'),
			'headTitle' 	=> Yii::t('app', 'Cursadas finalizadas'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			//'count'			=> $estadistica->nro_cursadas_finalizada,
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		$link = Url::toRoute(['/cursadas/create/index' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('plus'),
			'headTitle' 	=> Yii::t('app', 'Nueva cursada'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			'count'			=> '',
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		//Pagos
		$link = Url::toRoute([ $this->context->currentModule . '/pagos/index' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('credit-card-alt'),
			'headTitle' 	=> Yii::t('app', 'Pagos completados'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			//'count'			=> $estadistica->nro_estudiantes_pagos_al_dia,
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		//Pagos mora
		$link = Url::toRoute([ $this->context->currentModule . '/pagos-vencidos/index' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('history'),
			'headTitle' 	=> Yii::t('app', 'Pagos vencidos'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			//'count'			=> $estadistica->nro_estudiantes_pagos_moroso,
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		//
		$link = Url::toRoute([ $this->context->currentModule . '/pre-inscripcion/index' , 'idSucursal' => $this->context->model->id ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('user-plus'),
			'headTitle' 	=> Yii::t('app', 'Pre inscripción'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			//'count'			=> $estadistica->nro_estudiantes_preinscripcion,
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);

		//
		/*
		$link = Url::toRoute([ $this->context->currentModule . '/curso-consulta/index' ]);
		echo BoxNotification::widget([
			'icon' 			=> Fa::icon('question'),
			'headTitle' 	=> Yii::t('app', 'Consulta sobre curso'),
			'footerTitle' 	=> Yii::t('app', 'Administrar'),
			'visibility'	=> (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isAdminSucursal()),
			'link'			=> [ $link , ['data-pjax'=> 0] ]
		]);
		*/
	?>
</div>

<?php  Pjax::end() ?>
