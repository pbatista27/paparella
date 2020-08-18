<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="div-consultar-curso">

<div class="container clearfix text-center" style="width: auto; background:black; padding-left:40px; padding-right:40px; padding-top:40px;padding-bottom:40px;height: 100%;">
        <div id="divRecuperarClaveClose" style="cursor:pointer; position: absolute; top: 10px;right: 44px; font-size: 25px; color: white;">X</div>
        <div class="row">
            <div class="col-md-12">
            <h2 class="text-blanco text-uppercase">CONSULTAR CURSO</h2>
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
                        'action'    =>  Url::toRoute(['/site/consultar-curso']),
                        'enableAjaxValidation'=>true,
                        'validationUrl'=>Url::toRoute('/site/consultar-curso-ajax'),
                    ]);?>
                        <h3 id="contact_results" class=" italic regular baskerville text-blanco"></h3>
                        <div id="contact_body" class="controls">
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'nombres')->textInput(['placeholder'=>$model->getAttributeLabel('Nombres')]);?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'apellidos')->textInput(['placeholder'=>$model->getAttributeLabel('Apellidos')]);?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15">
                                <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'email')->textInput(['placeholder'=>$model->getAttributeLabel('Email')]);?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'telefono')->textInput(['placeholder'=>$model->getAttributeLabel('Telefono')]);?>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-15">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <?= $form->field($model, 'id_curso')->dropDownList($curso,['prompt'=>'Seleccion el curso']);?>
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