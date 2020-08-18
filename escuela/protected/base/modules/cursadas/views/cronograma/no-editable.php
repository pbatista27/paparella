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
				modal.size("modal-confirm")
				modal.header.show();
				modal.header.btnClose.show();
				modal.body.show();

				var btn = document.createElement("a");
					btn.setAttribute("class", "btn btn-primary");
					btn.setAttribute("href", "'. Url::toRoute([ $this->context->currentController . '/index', 'idCursada' => Yii::$app->request->get('idCursada') ]) .'");
					btn.setAttribute("data-role", "open-modal");
					btn.innerText = "'. Yii::t('app', 'Aceptar') .'";

				modal.footer.html(btn);
				modal.footer.show();
			})();
		'
	);
?>
<div class="text-center">
	<h5><?= $msn; ?></h5>
</div>
