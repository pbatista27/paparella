<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\helpers\Url;
    use yii\helpers\Json;
    use base\widgets\faicons\Fa;
    use yii\widgets\Pjax;
    use yii\bootstrap\ActiveForm;

    Pjax::begin([
        'id'                => $this->context->pjaxId,
        'enablePushState'   => false,
    ]);
?>

<div class="row" id="<?= $this->context->pjaxId; ?>">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="font-size:24px;color:#666; margin:0">
                        <?php echo Fa::icon($this->iconClass)->fw(); ?>
                        <?= $this->H1; ?>
                    </h1>
                    <div  style="padding-left:7px">
                        <small><?= Yii::t('app', 'Es requerido un nuevo cambio de contraseña'); ?></small>
                    </div>
                    <hr style="margin:0; margin-top:10px; margin-bottom:15px">
                </div>

                <div class="col-md-12 margin-v-15">
                    <?php
                        $form = ActiveForm::begin([
                            'id'                    => 'form' . $this->suffixDOM,
                            'enableClientScript'    => true,
                        ]);
                    ?>
                    <div class="row">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="container-fluid">
                                        <div class="row margin-top-15">
                                            <?php
                                                echo $form->field($this->context->model, 'new_password',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->passwordInput(['placeholder'=>$this->context->model->getAttributeLabel('new_password')]);
                                            ?>
                                        </div>

                                        <div class="row margin-top-15">
                                            <?php
                                                echo $form->field($this->context->model, 'repeat_password', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->passwordInput(['placeholder'=>$this->context->model->getAttributeLabel('repeat_password')]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                <div class="container-fluid margin-top-15">
                                    <div class="row">
                                        <div class="col-md-12 margin-top-15">
                                            <div class="pull-left">
                                                <?php
                                                    echo Html::a(Yii::t('app', 'Cancelar'), Url::toRoute(['/site/logout' ]), [
                                                        'class'     => 'btn btn-danger',
                                                        'data-pjax' => 0,
                                                        'data-title-confirm'    => Yii::t('app', 'Cancelar'),
                                                        'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea salir de sesion?'),
                                                        'data-runtime'          => 'ajax-confirm',
                                                        'data-label-btn-cancel' => Yii::t('yii', 'No'),
                                                        'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
                                                        //'data-icon-class'       => 'fa fa-trash',
                                                        //'data-force-redirect'   =>  Url::toRoute(['/' . $this->context->module->id . '/create/index']),
                                                    ]);
                                                ?>
                                            </div>
                                            <div class="pull-right">
                                                <?php echo Html::submitButton(Yii::t('app','Aceptar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $form::end();
                    ?>
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
                       window.location.href = "'. Url::toRoute(['/site/index']) .'";
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
                        //console.log(data);
                        //form.parent().rmLoader();
                        window.location.reload(true)
                    });

                    return false;
                });
            })();
        })()
        ', $this::POS_END
    );


    Pjax::end();
?>
