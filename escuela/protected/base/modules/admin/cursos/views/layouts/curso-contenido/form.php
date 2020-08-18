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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?php
                echo $form->field($this->context->model, 'archivo', [
                    'template' => '
                        <div>
                            <div class="text-center">{label}</div>
                            <div>
                                <div class="hidden">{input}</div>
                                <div class="text-center">{error}</div>
                                <div class="curso-archivo-upload text-center" id="file'. $this->suffixDOM .'">
                                </div>
                            </div>
                        </div>
                    ',
                ])->fileInput();
            ?>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
            <?php
                echo $form->field($this->context->model, 'nombre', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nombre')]);
            ?>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right  margin-v-15">
            <?php
                echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 'false']);
            ?>
        </div>
    </div>
</div>

<?php
	$form::end();

    $this->registerCss('
        .curso-archivo-upload{
            width:100px;
            height:100px;
            border-radius:8px;
            border:4px dotted #cecece;
            background:#f5f5f5;
            background-size:cover;
            background-position:center;
            margin:0 auto;
            margin-bottom:15px;
            cursor:pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .curso-archivo-upload > span {
            color:#cecece;
            font-size:24px;
        }

        .curso-archivo-upload > span.fa {
            font-size:34px;
        }
    ');

    if($this->context->model->hasFile())
    {
        $extension = $this->context->model->getFileExtension();
        $extension = (empty($extension)) ? '?' : '.' . strtoupper($extension);
        $extension = '<span>'. $extension .'</span>';
    }
    else
        $extension = '<span class="fa fa-plus"></span>';

	$this->registerJs('


		(function(){
			var conf = '.Json::Encode([
				'suffixDOM' 	=> $this->suffixDOM,
				'imputUpload'   => Html::getInputId($this->context->model, 'archivo'),
				'textError' 	=> Yii::t('yii', 'Error'),
				'textBtnOk' 	=> Yii::t('app', 'Aceptar'),
				'defaultIcon'   => $extension,
				'pjaxId'		=> $this->context->pjaxId,
			]).';

			var form = $("#form" + conf.suffixDOM);

			function defaultIcon()
			{
				$("#file" + conf.suffixDOM).html(conf.defaultIcon);
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
				}).text(conf.textBtnOk);

				// insert into footer modal
				modal.footer.html(btnClose).show();
				modal.body.addClass("text-center").html("<div class=\"text-center padding-v-15\">" +msn + "</div>").show();

				modal.registerEvent("beforeClose", function(){
					if(refreshOnClose == true )
						$.pjax.reload({container: "#" + conf.pjaxId });

				}, true);

				modal.open();
			}

			(function(){
	            $("#file" + conf.suffixDOM).on("click", function(e){
	                e.preventDefault();
	                $("#"+conf.imputUpload).click();
	            });

				// event on change Image:
				$("#"+conf.imputUpload).on("change", function(event){

					var input       = $(this);
					var file        = event.target.files[0];

					var pattern     = /\.([0-9a-z]+)(?=[?#])|(\.)(?:[\w]+)$/gmi
					var extension   = null;

					try{
					    extension   = (file.name).match(pattern)[0];
					    extension   = extension.toUpperCase();
					}
					catch(e){
					   extension = "?";
					}

					$("#file" + conf.suffixDOM).html("<span>"+ extension +"</span>");
				});

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
						console.log(data);
						modal.content.rmLoader();
						modalFlash(false, conf.textError + " " + data.status, data.responseText, true);
					});

					return false;
				});
			})();

			defaultIcon();

		})();

	', $this::POS_END);

