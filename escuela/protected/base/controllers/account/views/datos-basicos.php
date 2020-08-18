 <?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\Json;
    use yii\helpers\ArrayHelper;
    use base\widgets\faicons\Fa;
    use yii\bootstrap\ActiveForm;
    use kartik\date\DatePicker;

    $this->registerJs(
        '
            modal.reset.default();

            modal.size("modal-50");
            modal.content.addClass("fade in");
            modal.icon.attr("class", "fa fa-'. $this->iconClass .' fa-fw");
            modal.title.html("'. $this->H1 .'");
            modal.header.show();
            modal.header.btnClose.show();
            modal.body.show();
            modal.content.show();
            modal.footer.hide();

            (function(){
                var conf = '.Json::Encode([
                    'suffixDOM'   => $this->suffixDOM,
                    'imputUpload' => Html::getInputId($this->context->model, 'imagen_personal'),
                    'defaultImage'=> $this->context->model->getAvatar(),
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
                            $.pjax.reload({container: "#menu-item-avatar-content" });
                    }, true);

                    modal.open();
                }

                function setDefaultImage(){
                    $("#file" + conf.suffixDOM).css({
                        "background-image"    : "url("+conf.defaultImage+")",
                        "background-position" : "center",
                        "background-size"     : "cover",
                    });
                };

                (function(){

                    $("#file" + conf.suffixDOM).on("click", function(e){
                        e.preventDefault();
                        $("#"+conf.imputUpload).click();
                    });

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
                                "background-position" : "center",
                                "background-size"     : "cover",
                            });
                        }
                        reader.readAsDataURL(file)
                    });

                    form.on("beforeSubmit", function(event){
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

                            modalFlash(data.status, data.statusCode, data.statusText, true);
                            modal.rmLoader();
                        })
                        .fail(function(data){
                            //console.log(data);
                            //modal.rmLoader();
                            window.location.reload(true)
                        });

                        return false;
                    });

                })();

                setDefaultImage();
            })();

        ', $this::POS_END
    );

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

?>

<?php
    $form = ActiveForm::begin([
        'id'                    => 'form' . $this->suffixDOM,
        'enableClientScript'    => true,
    ]);
?>

<div class="container-fluid margin-v-15">
    <div class="row">
        <div class="col-md-3">
            <?php
                echo $form->field($this->context->model, 'imagen_personal', [
                    'template' => '
                        <div style="margin-top:-15px">
                            <div class="text-center">{label}</div>
                            <div>
                                <div class="hidden">{input}</div>
                                <div class="upload-file" id="file'. $this->suffixDOM .'"></div>
                                <div class="text-center">{error}</div>
                            </div>
                        </div>
                    ',
                ])->fileInput();
            ?>
        </div>

        <div class="col-md-9">
            <div class="container-fluid" style="padding:0">
                <div class="row">
                    <?php
                        echo $form->field($this->context->model, 'nombres',     [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nombres')]);
                        echo $form->field($this->context->model, 'apellidos',   [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('apellidos')]);
                    ?>
                </div>
                <div class="row">
                    <?php
                        $tipoDocumentoIdentidad = ArrayHelper::map(\app\models\TipoDocumentoIdentidad::find()->all(),'id','codigo');
                        echo $form->field($this->context->model,'id_tipo_doc',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->dropDownList($tipoDocumentoIdentidad, ['promt'=>'Seleccion un Tipo Documento'])->Label('Tipo Documento');
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
</div>

<div class="container-fluid margin-v-15">
    <div class="row">
        <div class="col-md-12 text-right">
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
?>
