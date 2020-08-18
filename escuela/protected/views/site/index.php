<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use base\widgets\dashboard\BoxNotification;
	use base\widgets\faicons\Fa;
?>
<div class="row ">
<?php
	/*
	echo BoxNotification::widget([
		'icon' 			=> Fa::icon('institution'),
		'headTitle' 	=> Yii::t('app', 'Sucursales'),
		'footerTitle' 	=> Yii::t('app', 'Administrar'),
		'visibility'	=> true, // aqui filtrar por perfil para hacer visible o no este box
		'link'			=> [Url::toRoute(['/sucursales/default/index']), $options=[] ],
		'count'			=> ($countSucursal)?:0,
	]);

	echo BoxNotification::widget([
		'icon' 			=> Fa::icon('file-text-o'),
		'headTitle' 	=> Yii::t('app', 'Cursos'),
		'footerTitle' 	=> Yii::t('app', 'Administrar'),
		'visibility'	=> true, // aqui filtrar por perfil para hacer visible o no este box
		'link'			=> [Url::toRoute(['/cursos/default/index']), $options=[] ],
		'count'			=> ($countCursos)?:0,
	]);

	echo BoxNotification::widget([
		'icon' 			=> Fa::icon('address-book-o'),
		'headTitle' 	=> Yii::t('app', 'Usuarios'),
		'footerTitle' 	=> Yii::t('app', 'Administrar'),
		'link'			=> [Url::toRoute(['/users/default/index']), $options=[] ],
		'visibility'	=> true, // aqui filtrar por perfil para hacer visible o no este box
		'count'			=> ($countSucursal)?:0,
	]);

	echo BoxNotification::widget([
		'icon' 			=> Fa::icon('history'),
		'headTitle' 	=> Yii::t('app', 'Historial de Pagos'),
		'footerTitle' 	=> Yii::t('app', 'Ver estadisticas'),
		'visibility'	=> true, // aqui filtrar por perfil para hacer visible o no este box
		'link'			=> [Url::toRoute(['/pagos/default/index']), $options=[] ],
		'count'			=> ($countSucursal)?:0,
	]);
	*/
?>
</div>

<div class="row" style="margin-top:80px">
	<?php
		echo Html::img( '@web/images/dashboard/logo-main.jpg', [
			'class' => 'img-block img-responsive',
			'alt'   => Yii::$app->name,
			'style' => 'display:block; margin: auto; width:500px;border:2px solid #231F20; border-radius:8px'
		]);
	?>
</div>
