<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\Json;
    use base\widgets\faicons\Fa;
    use yii\bootstrap\ActiveForm;

    $this->registerJs(
        '
            (function(){

                modal.reset.default();

                modal.icon.attr("class", "fa fa-'. $this->iconClass .' fa-fw");
                modal.title.html("'. $this->H1 .'");
                modal.header.show();
                modal.header.btnClose.show();
                modal.body.show();
                modal.footer.hide();
            })();
        '
    );

    $form = ActiveForm::begin([
    	'id' => 'form' . $this->suffixDOM,
    ]);
?>

<div class="container-fluid padding-v-15">
    <div class="row">
		<?php echo $form->field($this->context->model, 'facebook',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('facebook')]); ?>
		<?php echo $form->field($this->context->model, 'instagram',  [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('instagram')]); ?>
		<?php echo $form->field($this->context->model, 'twitter',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('twitter')]); ?>
    </div>
    <div class="row">
        <div class="col-md-12 text-right margin-top-15 margin-bottom-10">
            <?php
                echo Html::a(Yii::t('app','Cancelar'), $this->context->defaultRouteUrl , [
                    'class' => 'btn btn-danger',
                    'style' => 'margin-right:10px',
                    'data-role'=> 'open-modal',
                    'data-pjax' => 0
                ]);
            ?>
            <?php echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);?>
        </div>
    </div>
</div>

<?php
	$form::end();

	$this->registerJs('

		(function(){
			var conf = '.Json::Encode([
				'suffixDOM' => $this->suffixDOM,
				'textError' => Yii::t('yii', 'Error'),
				'textBtnOk' => Yii::t('app', 'Aceptar'),
				'pjaxId'	=> $this->context->pjaxId,
			]).';

			var form   = $("#form" + conf.suffixDOM);

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
				}).text(conf.textBtnOk);

				// insert into footer modal
				modal.footer.html(btnClose).show();
				modal.body.addClass("text-center").html("<div class=\"text-center padding-v-15\">" +msn + "</div>").show();

				modal.registerEvent("beforeClose", function(){
					if(refreshOnClose == true ){
						if($( "#" + conf.pjaxId ).length )
							$.pjax.reload({container: "#" + conf.pjaxId });
					}

				}, true);

				modal.open();
			}

			(function(){
				form.on("beforeSubmit", function(event){
					modal.content.addLoader();

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
						modal.content.rmLoader();
						if(data.status != true)
						{
							//modalFlash(data.status, conf.textError, data.statusText, false);
							form.yiiActiveForm("updateMessages", data.errors);
							return;
						}
						modalFlash(data.status, data.statusCode, data.statusText, true);
					})
                    .fail(function(data){
                        //console.log(data);
                        //modal.rmLoader();
                        window.location.reload(true)
                    });

					return false;
				});
			})();

		})();

	', $this::POS_END);
