 <?php
	use yii\helpers\Html;
	use base\widgets\faicons\Fa;
	use yii\helpers\Url;

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
?>
<div>
	<ul class="list-unstyled menu-account">
		<li><?= Html::a(Yii::t('app', 'Mis datos basicos'),   Url::toRoute([$this->context->currentController .'/datos-basicos']),    ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<?php if(Yii::$app->user->identity->isEstudiante() || true ): //true por ahora no se si dejarlo para todos ?>
		<li><?= Html::a(Yii::t('app', 'Mis datos contacto'),  Url::toRoute([$this->context->currentController .'/datos-contacto']),   ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<li><?= Html::a(Yii::t('app', 'Persona de contacto'), Url::toRoute([$this->context->currentController .'/persona-contacto']), ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<li><?= Html::a(Yii::t('app', 'Redes sociales'),      Url::toRoute([$this->context->currentController .'/redes-sociales']),   ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<?php endif; ?>
		<li><?= Html::a(Yii::t('app', 'Cambiar contraseña'),  Url::toRoute([$this->context->currentController .'/cambiar-password']), ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
	</ul>
</div>

