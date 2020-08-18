<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\Json;
	use base\widgets\faicons\Fa;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\ArrayHelper;
	use kartik\checkbox\CheckboxX;
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
						<div class="col-md-9 col-sm-12 col-xs-12">
							<?php
								$form = ActiveForm::begin([
									'id'					=> 'form' . $this->suffixDOM,
									'enableClientScript'    => true,
								]);
							?>
							<div class="container-fluid">

								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>

								<div class="row">
									<div class="col-md-3">
										<?php
											echo $form->field($this->context->model, 'foto_promocional', [
												'template' => '
													<div style="margin-top:-15px">
														<div class="text-center">{label}</div>
														<div>
															<div class="hidden">{input}</div>
															<div class="text-center">{error}</div>
															<div class="upload-file" id="file'. $this->suffixDOM .'"></div>
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
													echo $form->field($this->context->model, 'nombre',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nombre')]);
												?>
											</div>
											<div class="row">
												<?php
													echo $form->field($this->context->model, 'cantidad_meses',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('cantidad_meses')]);
													echo $form->field($this->context->model, 'cantidad_clases',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('cantidad_clases')]);
												?>
											</div>
											<div class="row">
												<?php
													echo $form->field($this->context->model, 'precio_matricula',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('precio_matricula')]);
													echo $form->field($this->context->model, 'precio_cuota',  [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('precio_cuota')]);
												?>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<?php
														echo $form->field($this->context->model, 'activo', [
															'template' => '{input}{label}{error}{hint}',
															'labelOptions' => ['class' => 'cbx-label']
														])->widget(CheckboxX::classname(), [
															'autoLabel'=>false,
															'pluginOptions'=>['threeState'=>false],
														]);
													?>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 text-right">
										<?php echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);?>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<hr>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 text-center">
									<?php
										if($this->context->model->is_tmp == true && $this->context->model->isNewRecord == false)
										{
											echo Html::a(Yii::t('app', 'Cancelar'), Url::toRoute(['/' . $this->context->module->id . '/create/cancel' ]), [
												'class'     => 'btn btn-danger',
												'style'     => 'margin-right:10px',
												'data-pjax' => 0,
												'data-title-confirm'    => Yii::t('app', 'Cancelar'),
												'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea cancelar el registro?'),
												'data-runtime'          => 'ajax-confirm',
												'data-label-btn-cancel' => Yii::t('yii', 'No'),
												'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
												'data-icon-class'       => 'fa fa-trash',
												'data-pjax-target'		=> '#' . $this->context->pjaxId,
											]);

											echo Html::a(Yii::t('app','Siguiente')    . ' ' . Fa::icon('arrow-right')->fw()  , Url::toRoute(['/' . $this->context->module->id . '/create/programacion']) , ['style'=>'margin-right:10px','class' => 'btn btn-primary', 'data-pjax' => 0]);
										}
									?>
									</div>
								</div>
							</div>
							<?php $form::end() ?>
						</div>

						<div class="col-md-3 col-sm-12 col-xs-12">
							<?php
								if($this->context->model->is_tmp || $this->context->model->isNewRecord)
									echo $this->render('_menuCreate');
								else
									echo $this->render('_menu');
							?>
						</div>
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
			height:218px;
			border-radius:6px;
			border:1px solid #cecece;
			background-color: #ebebeb;
			background-image:url("'. Yii::getAlias("@web/images/dashboard/not-image.jpg") .'");
			background-size:218px;
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
				'imputUpload' => Html::getInputId($this->context->model, 'foto_promocional'),
				'defaultImage'=> $this->context->model->getImage(),
				'isNewRecord' => $this->context->model->isNewRecord,
			]).';

			var form = $("#form" + conf.suffixDOM);
			form.hasError = function(){return form.find(".has-error").length;};

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
						//form.parent().addLoader();
						window.location.reload(true)
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
