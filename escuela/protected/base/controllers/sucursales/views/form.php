<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\Json;
	use base\widgets\faicons\Fa;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\widgets\Pjax;

	Pjax::begin([
		'id'                => $this->context->pjaxId,
		'enablePushState'   => false,
	]);
?>

<div class="row" id="<?= $this->context->pjaxId; ?>">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo Fa::icon($this->iconClass); ?>
					<?= $this->H1; ?>
				</h3>
			</div>
			<div class="panel-body" >
				<div class="container-fluid margin-v-30">
					<div class="row">
						<div class="col-md-12">
							<?php
								$form = ActiveForm::begin([
									'id'					=> 'form' . $this->suffixDOM,
									'enableClientScript'    => true,
								]);
							?>
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<h5><?= Yii::t('app','Datos basicos') ?></h5>
												<hr>
											</div>
										</div>
										<div class="row">
											<?php
												echo $form->field($this->context->model, 'id_localidad', [ 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'] ])->widget(\kartik\select2\Select2::classname(), [
												'initValueText' => empty($this->context->model->id_localidad) ? '' : $this->context->model->getLocalidad()->one()->keyword,
												'options'       => ['placeholder' => $this->context->model->getAttributeLabel('id_localidad') ],
													'pluginOptions' => [
														'allowClear' => true,
														'minimumInputLength' => 2,
														'ajax' => [
															'url'       => Url::toRoute(['/ajax/localidad']),
															'dataType'  => 'json',
															'data'      => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
															'cache'     => true,
														],
														'escapeMarkup'      => new \yii\web\JsExpression('function (data) { return data; }'),
														'templateResult'    => new \yii\web\JsExpression('function(data)  { return data.text; }'),
														'templateSelection' => new \yii\web\JsExpression('function (data) { return data.text; }'),
													],
												]);

												echo $form->field($this->context->model, 'nombre', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nombre')]);
											?>
										</div>

										<div class="row">
										    <div class="padding-top-15">
										        <?php
										            echo $form->field($this->context->model, 'email',         [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('email')]);
										            echo $form->field($this->context->model, 'codigo_postal', ['inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])
										            	->widget(\yii\widgets\MaskedInput::className(),    [ 'mask' =>  '9999' ]);
										        ?>
										    </div>
										</div>

										<div class="row">
										    <div class="padding-top-15">
										        <?php
										            echo $form->field($this->context->model, 'direccion',  [ 'inputOptions' => ['autocomplete' => 'off', 'style' => 'min-height:145px'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->textArea(['placeholder'=>$this->context->model->getAttributeLabel('direccion')]);
										        ?>
										    </div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-12">
												<h5><?= Yii::t('app','Numeros teléfonicos') ?></h5>
												<hr>
											</div>
										</div>
										<div class="row">
										<?php
											echo $form->field($this->context->model, 'id_tipo_num1', ['options'=>['class'=>'col-xs-12 col-sm-12 col-md-12']])->widget(\kartik\select2\Select2::classname(), [
												'data' 		=> $this->context->model->getMapTipoNum(),
												'options' 	=> ['placeholder' => $this->context->model->getAttributeLabel('id_tipo_num1')],
												'pluginOptions' => [
													'allowClear' 	=> true,
													'selectOnClose' => true
												],
											]);
											echo $form->field($this->context->model, 'numero1',         [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-8']])
												->textInput(['placeholder'=>$this->context->model->getAttributeLabel('numero1')]);

											echo $form->field($this->context->model, 'extension1', ['inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4']])
												->textInput(['placeholder'=>$this->context->model->getAttributeLabel('extension1')]);
										?>
										</div>

										<div class="row">
											<div class="col-md-12">
												<hr>
											</div>
										</div>

										<div class="row">
										<?php
											echo $form->field($this->context->model, 'id_tipo_num2', ['options'=>['class'=>'col-xs-12 col-sm-12 col-md-12']])->widget(\kartik\select2\Select2::classname(), [
												'data' 		=> $this->context->model->getMapTipoNum(),
												'options' 	=> ['placeholder' => $this->context->model->getAttributeLabel('id_tipo_num2')],
												'pluginOptions' => [
													'allowClear' 	=> true,
													'selectOnClose' => true
												],
											]);
											echo $form->field($this->context->model, 'numero2',         [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-8']])
												->textInput(['placeholder'=>$this->context->model->getAttributeLabel('numero2')]);

											echo $form->field($this->context->model, 'extension2', ['inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4']])
												->textInput(['placeholder'=>$this->context->model->getAttributeLabel('extension2')]);
										?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
									<div class="col-md-12 text-right">
										<?php
											echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 0]);
										?>
									</div>
								</div>
							</div>
							<?php $form::end() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$this->registerJs(
		'
		(function(){
			var conf = '.Json::Encode([
				'suffixDOM'   => $this->suffixDOM,
				'isNewRecord' => $this->context->model->isNewRecord,
			]).';

			var form = $("#form" + conf.suffixDOM);

			function modalFlash(status,title,msn, refreshOnClose){
				var refreshOnClose = (refreshOnClose == true ? true : false) || false;
				modal.reset.default();

				if(status == true)
					modal.icon.attr("class", "fa fa-check text-success");
				else
					modal.icon.attr("class", "fa fa-times text-danger");

				modal.title.html(title);
				modal.header.show();
				modal.size("modal-confirm");

				// add element button
				var btnClose = $("<button>").attr({
					"type"         : "button",
					"class"        : "btn btn-info",
					"data-dismiss" : "modal",
				}).text("' . Yii::t('app', 'Aceptar') .'");

				// insert into footer modal
				modal.footer.html(btnClose).show();
				modal.body.addClass("text-center").html("<div class=\"text-center padding-v-15\">" +msn + "</div>").show();


				modal.registerEvent("beforeClose", function(){
					if(refreshOnClose == true )
						$.pjax.reload({container: "#" + "'. $this->context->pjaxId .'"});

				}, true);

				modal.open();
			}

			(function(){
				form.on("beforeSubmit", function(event){
					form.parent().addLoader();

					$.ajax({
						url : form.attr("action"),
						type: form.attr("method"),
						data: new FormData(form[0]),
						processData: false,
						cache: false,
						contentType: false,
						dataType : "JSON",
					})
					.done(function(data){
						if(data.status != true)
						{
							modalFlash(data.status, "'.Yii::t('yii', 'Error').'", data.statusText, false);
							form.yiiActiveForm("updateMessages", data.errors);
							form.parent().rmLoader();
							return;
						}

						modalFlash(data.status, data.statusCode, data.statusText, true);
					})
					.fail(function(data){
						console.log(data);
						form.parent().rmLoader();
						//window.location.reload(true)
					});

					return false;
				});

			})();
		})()
		', $this::POS_END
	);

 Pjax::end();
?>
