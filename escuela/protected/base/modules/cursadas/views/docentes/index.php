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

	$idCursada = Yii::$app->request->get('idCursada');
?>

<div>
	<ul class="list-unstyled menu-action">
		<li><?= Html::a(Yii::t('app', 'Agregar docente'),  Url::toRoute([$this->context->currentController .'/add',  'idCursada' =>  $idCursada ]), ['data-pjax' => 0, 'data-role'=> 'open-modal' ]) ?></li>
		<li><?= Html::a(Yii::t('app', 'Eliminar docente'), Url::toRoute([$this->context->currentController .'/rm', 	 'idCursada' =>  $idCursada ]), ['data-pjax' => 0, 'data-role'=> 'open-modal' ]) ?></li>
	</ul>
</div>

