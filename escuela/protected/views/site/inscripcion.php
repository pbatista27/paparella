<?php 
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Sucursal;
use app\models\Curso;

$sucursal = ArrayHelper::map(Sucursal::find()->select('id,nombre')->where(['activo'=>1])->asArray()->all(),'id','nombre');
$curso = ArrayHelper::map(Curso::find()->select('id,nombre')->where(['activo'=>1])->asArray()->all(),'id','nombre');

?>
<!--div inscripciones-->
<div class="divInscripciones">
    <div class="container clearfix text-center" style="width: auto; background:black; padding-left:40px; padding-right:40px; padding-top:40px;padding-bottom:40px;height: 100%;">
        <div id="divRecuperarClaveClose" style="cursor:pointer; position: absolute; top: 10px;right: 44px; font-size: 25px; color: white;">X</div>
        <div class="row">
            <div class="col-md-12">
            <h2 class="text-blanco text-uppercase">INSCRIPCIÓN ONLINE</h2>
            <?=
            Html::img(Yii::getAlias('@web/images/guest/linea-blanca.png'),[
                'alt'    => Yii::$app->name,
                'title'  => Yii::$app->name,
                'style'=> 'margin-bottom: 10px;',
                'class'=> 'img-responsive mbot-30 center-block'
            ]);
            ?>
            <div class="row" style="color: white;">
                <div class="col-md-6 col-md-offset-3" style=" margin-left: 0; width: 100%;">
                    <?php $form = ActiveForm::begin([
                        'id'=>$model->formName(),
                        'action'    =>  Url::toRoute([$this->context->currentRoute]),
                        'enableAjaxValidation'=>true,
                        'validationUrl'=>Url::toRoute('/site/validar-inscripcion-ajax'),
                    ]);?>
                        <h3 id="contact_results" class=" italic regular baskerville text-blanco"></h3>
                        <div id="contact_body" class="controls">
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'nombres')->textInput(['placeholder'=>$model->getAttributeLabel('Nombre')]);?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'apellidos')->textInput(['placeholder'=>$model->getAttributeLabel('Apellido')]);?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'dni')->textInput(['placeholder'=>$model->getAttributeLabel('Dni')]);?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'email')->textInput(['placeholder'=>$model->getAttributeLabel('Mail')]);?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'direccion')->textInput(['placeholder'=>$model->getAttributeLabel('Direccion')]);?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                       <?php
                                        echo $form->field($model, 'id_localidad')->widget(\kartik\select2\Select2::classname(), [
                                            //'initValueText' => empty($model->id_localidad) ? '' : $model->getIdLocalidad()->one()->keyword,
                                            'options'       => ['placeholder' => $model->getAttributeLabel('id_localidad') ],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'minimumInputLength' => 2,
                                                    'ajax' => [
                                                        'url'       => Url::toRoute(['/ajax/localidad']),
                                                        'dataType'  => 'json',
                                                        'data'      => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
                                                        'cache'     => true,
                                                    ],
                                                    'escapeMarkup'      => new \yii\web\JsExpression('function (data) { return data; }'),
                                                    'templateResult'    => new \yii\web\JsExpression('function(data)  { return data.text; }'),
                                                    'templateSelection' => new \yii\web\JsExpression('function (data) { return data.text; }'),
                                                ],
                                            ]);
                                       ?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'telefono')->textInput(['placeholder'=>$model->getAttributeLabel('telefono')]);?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'id_curso')->dropDownList($curso, ['prompt'=>'Seleccione Curso']);?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'id_sucursal')->dropDownList($sucursal, ['prompt'=>'Seleccione Sucursal']);?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15 margin-top-15">
                                <div class="row">
                                    <?php echo Html::submitButton(Yii::t('app', 'ENVIAR') , ['class' => 'btn btn-block','style' => 'background-color:white; color:black; height:37px']) ?>
                                </div>
                            </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!--fin del div inscripciones-->