<?php
    use yii\bootstrap\ActiveForm;
    use yii\captcha\Captcha;
    use yii\helpers\Url;
    use yii\bootstrap\Html;
    use base\widgets\faicons\Fa;
?>
<div class="divRecuperarContrasena">
     <div class="row">
         <div>

             <div class="container clearfix text-center" style=" width: 100% !important;     padding: 50px;       background: black;    color: white;    min-height: 400px;    display: table;    position: relative;">
                 <div class="cursorPointer" id="divRecuperarClaveClose" style="cursor:pointer; position: absolute; top: 10px;right: 15px; font-size: 25px;">X</div>
                 <div class="row" style="     display: table-cell;    vertical-align: middle;    width: 100%;">
                     <div class="col-md-12">
                     <?php
                        $form = ActiveForm::begin([
                            'id'        => 'recovery' . $this->suffixDOM,
                            'action'    =>  Url::toRoute([$this->context->currentRoute]),
                            'enableAjaxValidation'=>true,
                            'validationUrl'=>Url::toRoute('/site/validar-recovery-ajax'),
                            'options'   => ['role'  => 'form']
                        ]);
                        ?>
                             <h2 class="text-blanco text-uppercase">Recuperar Clave</h2>
                             <?=
                               Html::img(Yii::getAlias('@web/images/guest/linea-blanca.png'),[
                                 'alt'    => Yii::$app->name,
                                 'title'  => Yii::$app->name,
                                 'class'=> 'img img-responsive mbot-30 center-block'
                               ]);
                              ?>
                             <div class="row">
                                     <div class="col-md-6 col-md-offset-3">
                                         <div id="contact_form" class="form-style contact-form form">
                                             <h3 id="contact_results" class=" italic regular baskerville text-blanco"></h3>
                                             <div id="contact_body" class="controls">
                                             <?php echo $form->field($model, 'email', ['inputOptions' => ['class'=> 'col-xs-12 form-control','autocomplete' => 'off']] )->textInput(['placeholder'=>$model->getAttributeLabel('email')]);?>
                                                 <div class="text-center" style=" margin-top:35px;">
                                                    <?php echo Html::submitButton(Yii::t('app', 'Enviar') , ['class' => 'btn-block btn center-block', 'name' => 'login-button', 'style'=>'background-color:white; color:black;']) ?>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>

                    </div>
                </div>

            </div>
            <div style="padding-left:17px;">
                <p>
                    <a href="#" id="formLogin" style='color:white;'>volver al form login</a>
                </p>
            </div>
     </div>
 </div>
