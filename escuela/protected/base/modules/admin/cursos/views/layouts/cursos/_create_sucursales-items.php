<?php
	use yii\helpers\Html;
	use yii\helpers\Url;

	/*
	$ckTarget = 'ck' . $this->suffixDOM;
	$module   = '/'. $this->context->module->id;
	$route    = Url::toRoute([$module . '/default/status-sucursal']);

	$this->registerJs(
		'
		(function(){
			$(document).on("click", \'[data-target="'.$ckTarget.'"]\', function(e){
				var ck 		   = $(this);
				var isChecked  = ck.is(":checked");
				var content    = $("#loader-'. $ckTarget .'");
				var curso	   = "'.$this->context->model->id .'";
				var url        = "'. $route .'";
				content.addLoader();
				$.ajax({
					url  : url,
					data : {id : curso, idSucursal : ck.attr("name")},
				})
				.done(function(data){

					if(data.status != true)
					{
						if(typeof data.statusText == "undefined"){
							window.location.reload(true)
							return;
						}

						modal.reset.default();
						modal.icon.attr("class", "fa fa-times text-danger");

						modal.title.html(data.statusCode);
						modal.header.show();
						modal.size("modal-confirm");

						// add element button
						var btnClose = $("<button>").attr({
							"type"         : "button",
							"class"        : "btn btn-info",
							"data-dismiss" : "modal",
						}).text("'.Yii::t('app' , 'Aceptar') .'");

						// insert into footer modal
						modal.footer.html(btnClose).show();
						modal.body.addClass("text-center").html("<div class=\"text-center padding-v-15\">" + data.statusText + "</div>").show();

						modal.registerEvent("beforeClose", function(){
							$.pjax.reload({container: "#'. $this->context->pjaxId .'" });
						}, true);

						modal.open();
						return;
					}

					content.rmLoader();
				})
				.fail(function(data){
					content.rmLoader();
				})
			});
		})();
		',
		$this::POS_END
	);
	*/
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<h5 style="margin-bottom:-10px"><?= Yii::t('app', 'Seleccione las sucursales disponibles para este curso');?></h5>
			<hr>
		</div>
	</div>
	<div class="row">
		<?php
			foreach($sucursales as  $item):
				$item = (object) $item;
		?>
		<div class="col-sm-4">
			<div class="pull-left" style="margin-right:15px;margin-bottom:10px">
				<input  type="checkbox" name="sucursal[]" value="<?= $item->id ?>" checked="checked" style="width:23px; height:23px">
			</div>
			<div class="pull-left">
				<label style="line-height:24px"><?= $item->nombre ?></label>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="row">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 text-right">
				<?php echo Html::submitButton(Yii::t('app','Finalizar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);?>
			</div>
		</div>

		<div class="col-md-12">
			<hr>
		</div>
	</div>
</div>
