 <?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\Json;
    use base\widgets\faicons\Fa;
    use yii\bootstrap\ActiveForm;

    $this->registerJs(
        '
            modal.reset.default();
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
                    'suffixDOM' => $this->suffixDOM,
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

                (function(){

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

            })();

        ', $this::POS_END
    );
?>

<?php
    $form = ActiveForm::begin([
        'id'                    => 'form' . $this->suffixDOM,
        'enableClientScript'    => true,
    ]);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid">
                <div class="row margin-top-15">
                    <?php
                        echo $form->field($this->context->model, 'current_password',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12']])->passwordInput(['placeholder'=>$this->context->model->getAttributeLabel('current_password')]);
                    ?>
                </div>
                <div class="row margin-top-15">
                    <?php
                        echo $form->field($this->context->model, 'new_password',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->passwordInput(['placeholder'=>$this->context->model->getAttributeLabel('new_password')]);
                        echo $form->field($this->context->model, 'repeat_password', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->passwordInput(['placeholder'=>$this->context->model->getAttributeLabel('repeat_password')]);
                    ?>
                </div>

                <div class="row margin-v-15">
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
        </div>
    </div>
</div>

<?php
    $form::end();
?>
