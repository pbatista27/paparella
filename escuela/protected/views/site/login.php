<?php
    use yii\bootstrap\ActiveForm;
    use yii\captcha\Captcha;
    use yii\helpers\Url;
    use yii\bootstrap\Html;
    use base\widgets\faicons\Fa;
?>

<div class="divLogin">
     <div class="container clearfix text-center" id="divLoginContent" style=" width: 100% !important;     padding: 50px;       background: black;    color: white;    min-height: 400px;    display: table;    position: relative;">
             <div id="divRecuperarClaveClose" style="cursor:pointer; position: absolute; top: 10px;right: 15px; font-size: 25px;">X</div>
         <div class="row" id="divLoginContentTop" style="vertical-align: middle;    width: 100%;">
             <div class="col-md-12" style="padding-right: 0px;    padding-left: 0px; ">
               <?php $form = ActiveForm::begin([
                   'id'        => 'login' . $this->suffixDOM,
                   'action'    =>  Url::toRoute([$this->context->currentRoute]),
                   'enableClientValidation'=>false,
                   'enableAjaxValidation'=>true,
                   'validationUrl'=>Url::toRoute('/site/validar-login-ajax'),
                   'options'   => ['role'  => 'form']
               ]); ?>
                   <h2 class="text-blanco text-uppercase">Ingresar</h2>
                   <?=
                     Html::img(Yii::getAlias('@web/images/guest/linea-blanca.png'),[
                       'alt'    => Yii::$app->name,
                       'title'  => Yii::$app->name,
                       'class'=> 'img img-responsive mbot-30 center-block'
                     ]);
                    ?>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3" style="padding-right: 0px;    padding-left: 0px; ">
                            <div>
                                  <div class="controls">
                                        <?= $form->field($model, 'username')->textInput(['maxlength'=>'true'])->Label('Correo'); ?>
                                        <?= $form->field($model, 'password')->passwordInput(['maxlength'=>'true'])->Label('Clave'); ?>
                                      <div class="text-center" style=" margin-top:35px;">
                                          <?php echo Html::submitButton(Yii::t('app', 'Enviar') , ['class' => 'btn btn-block','style' => 'background-color:white; color:black',  'name' => 'login-button']) ?>
                                      </div>
                                  </div>
                            </div>
                        </div>
                    </div>
               <?php ActiveForm::end(); ?>
                     <?=
                       Html::img(Yii::getAlias('@web/images/guest/linea-blanca.png'),[
                         'alt'    => Yii::$app->name,
                         'title'  => Yii::$app->name,
                         'class'=> 'img img-responsive mbot-30 center-block'
                       ]);
                      ?>
                 </div>
             </div>
         </div>
         <div>
             <a href="<?=Url::toRoute(['site/recovery']);?>" class="formRecuperar" style='color:white'>Recuperar contraseña</a>
         </div>
 </div>
