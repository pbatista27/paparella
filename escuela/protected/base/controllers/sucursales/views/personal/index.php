 <?php
	use yii\helpers\Html;
	use base\widgets\faicons\Fa;
	use yii\helpers\Url;
	use base\models\UserIdentity;

	$this->registerJs(
		'
			(function(){
				modal.reset.default();
				modal.icon.attr("class", "fa fa-'. $this->iconClass .' fa-fw");
				modal.title.html("'. $this->H1 .'");
				modal.size("modal-sm")
				modal.header.show();
				modal.header.btnClose.show();
				modal.body.show();
				modal.footer.hide();
			})();
		'
	);

	switch (true)
	{
		case ($this->context->action->perfil ==  UserIdentity::PROFILE_ADMIN_SUCURSAL):
			$prefixRoute = $this->context->currentController . '/administradores';
			break;

		case ($this->context->action->perfil ==  UserIdentity::PROFILE_DOCENTE):
			$prefixRoute = $this->context->currentController . '/docentes';
			break;
	}
?>

<div>
	<ul class="list-unstyled menu-action">
		<li><?= Html::a(Yii::t('app', 'Nuevo usuario'), 			 Url::toRoute([$prefixRoute . '-create'    , 'idSucursal' => $this->context->model->id ]), ['data-pjax' => 0 , 'data-role' => 'open-modal']) ?></li>
		<li><?= Html::a(Yii::t('app', 'Agregar usuario  existente'), Url::toRoute([$prefixRoute . '-add-users' , 'idSucursal' => $this->context->model->id ]), ['data-pjax' => 0 , 'data-role' => 'open-modal']) ?></li>
		<li><?= Html::a(Yii::t('app', 'Administrar todos'), 		 Url::toRoute([$prefixRoute . '-list'      , 'idSucursal' => $this->context->model->id ]), ['data-pjax' => 0 , 						      ]) ?></li>
	</ul>
</div>

