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
	<ul class="list-unstyled menu-action">
		<li><?= Html::a(Yii::t('app', 'Pagos por estudiantes'),  Url::toRoute([$this->context->currentController .'/datos-basicos']),    ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<li><?= Html::a(Yii::t('app', 'Agregar Pagos'),     	 Url::toRoute([$this->context->currentController .'/datos-basicos']),    ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<li><?= Html::a(Yii::t('app', 'Listado de deudas'),		 Url::toRoute([$this->context->currentController .'/datos-basicos']),    ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
		<li><?= Html::a(Yii::t('app', 'Listado de completados'), Url::toRoute([$this->context->currentController .'/datos-basicos']),    ['data-role'=> 'open-modal', 'data-pjax' => 0 ]) ?></li>
	</ul>
</div>

