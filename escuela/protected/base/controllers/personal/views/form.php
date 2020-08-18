<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\Json;
	use base\widgets\faicons\Fa;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\ArrayHelper;
	use kartik\date\DatePicker;
	use app\models\Sucursal;
	use yii\widgets\Pjax;


	$sucursales = Sucursal::find()->orderBy('nombre asc')->asArray()->all();
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
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<?php
								$form = ActiveForm::begin([
									'id'					=> 'form' . $this->suffixDOM,
									'enableClientScript'    => true,
								]);
							?>
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-3">
										<?php
											echo $form->field($this->context->model, 'imagen_personal', [
												'template' => '
													<div style="margin-top:-15px">
														<div class="text-center">{label}</div>
														<div>
															<div class="hidden">{input}</div>
															<div class="text-center">{error}</div>
															<div class="upload-file" id="file'. $this->suffixDOM .'"></div>
															<div class="text-center">
																<!--
																<div class="btn-group" role="group" style="margin-top:5px">
																	<button id="btn-upload'. $this->suffixDOM .'" type="button" class="btn btn-default">
																		<i class="fa fa-upload"></i>
																		<span class="hidden-sm">' . Yii::t('app', 'Subir') .'</span>
																	</button>
																</div>
																-->
															</div>
														</div>
													</div>
												',
											])->fileInput();
										?>
									</div>
									<div class="col-md-9">
										<div class="container-fluid">
											<div class="row">
												<?php
													echo $form->field($this->context->model, 'nombres',     [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nombres')]);
													echo $form->field($this->context->model, 'apellidos',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('apellidos')]);
												?>
											</div>
											<div class="row">
												<?php
													$tipoDocumentoIdentidad = ArrayHelper::map(\app\models\TipoDocumentoIdentidad::find()->all(),'id','codigo');
													echo $form->field($this->context->model,'id_tipo_doc',	  [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->dropDownList($tipoDocumentoIdentidad, ['promt'=>'Seleccion un Tipo Documento'])->Label('Tipo Documento');
													echo $form->field($this->context->model, 'nro_documento', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nro_documento')]);
												?>
											</div>
											<div class="row">
												<?php
													echo $form->field($this->context->model, 'email', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('email')]);
													echo $form->field($this->context->model, 'fecha_nacimiento', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('fecha_nacimiento')])->widget(DatePicker::classname(), [
														'options' => ['placeholder' => 'Fecha de nacimiento', 'autocomplete' => 'off' ],
														'language'=>'es',
														'pluginOptions' => [
															'autoclose'=>true,
															'format'=>'yyyy-mm-dd',
												  		],
													]);
												?>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>

								<div class="row">
									<?php
										if(empty($sucursales))
											echo '<div class="col-md-12 text-center margin-v-30 padding-v-15" style=""><h3>'.Yii::t('app', 'No tiene ninguna sucursal activa disponible!<br> <small>Favor entrar en el panel de sucursales para crear una sucursal</small>').'</h3></div>';

										else{
											echo '<div class="col-md-12 margin-b-10 padding-b-10 text-center"><h5>' . Yii::t('app','Sucursales activas para este usuario') .'</h5>';
										}
										foreach($sucursales as $item)
										{
											$item     = (object) $item;
											if($this->context->model->isNewRecord )
												$checked =  null;
											else
												$checked  =  in_array($item->id, $this->context->model->sucursales) ? 'checked="checked"' : null;
										?>
											<div class="col-sm-4">
												<div class="pull-left" style="margin-right:15px">
													<input  type="checkbox" name="Personal[sucursales][]" value="<?= $item->id ?>"  <?= $checked ?> style="width:23px; height:23px">
												</div>
												<div class="pull-left">
													<label style="line-height:24px"><?= $item->nombre ?></label>
												</div>
											</div>
										<?php
										}
									?>
								</div>
								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 text-right">
										<?php echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);?>
									</div>
								</div>
							</div>
							<?php $form::end() ?>
						</div>
						<div class="col-md-2"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$this->registerCss('
		.upload-file{
			width:100%;
			height:164px;
			border-radius:6px;
			border:1px solid #cecece;
			background-image:url("'. Yii::getAlias("@web/images/dashboard/default-avatar.jpg") .'");
			background-size:164px;
			background-position:center;
			background-repeat:no-repeat;
			cursor:pointer;
		}
	');

	$this->registerJs(
		'
		(function(){
			var conf = '.Json::Encode([
				'suffixDOM'   => $this->suffixDOM,
				'imputUpload' => Html::getInputId($this->context->model, 'imagen_personal'),
				'defaultImage'=> $this->context->model->getAvatar(),
				'isNewRecord' => $this->context->model->isNewRecord,
			]).';

			var form = $("#form" + conf.suffixDOM);

			function setDefaultImage(){
				$("#file" + conf.suffixDOM).css({
					"background-image"    : "url("+conf.defaultImage+")",
					"background-position" : "center",
					"background-size"     : "cover",
				});
			};

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
				// register event click image
				var eCliks = [
					$("#file" + conf.suffixDOM),
					$("#btn-upload" + conf.suffixDOM),
				];

				$(eCliks).each(function(){
					$(this).on("click", function(e){
						e.preventDefault();
						$("#"+conf.imputUpload).click();
					})
				});

				// event on change Image:
				$("#"+conf.imputUpload).on("change", function(event){

					var input = $(this);
					var file = event.target.files[0];

					if((/\.(png|jpeg|jpg)$/i).test(file.name) == false)
					{
						input.val("");
						setDefaultImage();
						return false;
					}

					var reader = new FileReader();
					reader.onload   = function(event){
						var img = event.target.result;

						$("#file" + conf.suffixDOM).css({
							"background-image"    : "url("+ img +")",
							"background-position" : "top center",
							"background-size"     : "cover",
						});
					}
					reader.readAsDataURL(file)
				});

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
						//window.location.reload(true)
						form.parent().rmLoader();
					});

					return false;
				});

			})();

			setDefaultImage();
		})()
		', $this::POS_END
	);

 	Pjax::end();
 ?>
