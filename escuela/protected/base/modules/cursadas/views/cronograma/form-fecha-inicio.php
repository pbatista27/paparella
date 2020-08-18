<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\Json;
	use base\widgets\faicons\Fa;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\ArrayHelper;
	use kartik\date\DatePicker;
	use yii\widgets\Pjax;

	$form = ActiveForm::begin([
		'id' => 'form' . $this->suffixDOM,
	]);
?>

<div class="container-fluid">
	<div class="row">
		<?php
			echo $form->field($this->context->model, 'fecha_inicio', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('fecha_nacimiento')])->widget(DatePicker::classname(), [
				'options' => ['placeholder' => $this->context->model->getAttributeLabel('fecha_inicio'), 'autocomplete' => 'off' ],
				'language'=>'es',
				'pluginOptions' => [
					'autoclose'=>true,
					'format'=>'yyyy-mm-dd',
		  		],
			]);
		?>

		<div class="row" style="margin:15px">
			<div class="text-right" style="margin-top:75px">
				<?php echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]); ?>
			</div>
		</div>
	</div>
</div>
<?php
	$form::end();

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

				// form:
				(function(){
					var form         = $("#form'.$this->suffixDOM.'");
					var oldAttribute = "'. $this->context->model->fecha_inicio .'";

					form.on("beforeSubmit", function(event){
						var attribute =  $("#'.Html::getInputId($this->context->model, 'fecha_inicio').'").val();

						if(attribute == oldAttribute)
						{
							modal.close();
							return false;
						}

						modal.addLoader();

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
                        		form.yiiActiveForm("updateMessages", data.errors);
                        		modal.rmLoader();
                        		return;
                        	}
                        	else{
                        		modal.registerEvent("afterClose", function(){
                        			modal.rmLoader();
                        			$("#grid").yiiGridView("applyFilter");
                        		}, true);

                        		modal.close();
                        	}
                        })
                        .fail(function(data){
                            console.log(data);
                            modal.rmLoader();
                            //window.location.reload(true)
                        });

						return false;
					});
				})();
			})();
		',
	$this::POS_END);
?>
