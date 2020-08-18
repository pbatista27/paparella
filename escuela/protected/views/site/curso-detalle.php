<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<section id="sectionCursoDetalle" class="section-black whiteBackground viewFront notShow" style="">
    <div class="container clearfix text-center">
        <div class="row">
            <div class="col-md-12">
                <h2 class=" text-uppercase"></h2>
                <div class="row">
                    <div class="" style=" color: black;">
                        <div class="" id="divCursoDetalle">
                            <div class="" id="" style="     display: inline-block;">
                                <?=
                                Html::img($model->getImage(),[
                                    'alt'    => Yii::$app->name,
                                    'title'  => Yii::$app->name,
                                    'style'=> 'margin-top: 32px; width:700px; display: inline-block;',
                                ]);
                                ?>
                            </div>
                            <div class="" id="" style="     display: inline-block; vertical-align: top;  width: 278px;    margin-left: 37px; ">
                                <div class="" id="divCursoDetalleTitulo" style=" font-weight:bold;margin-bottom:30px; font-size:16px;text-transform: uppercase;"><?=$model->nombre ?></div>
                                <div class="" id="divCursoDetalleContenido" style=" text-align:left;">
                                    <div>
                                        <?php
                                            foreach ($model->getCursoProgramacions()->all() as $item) {
                                                ?>
                                                <div>
                                                    <h4><?= Html::encode($item->titulo) ?></h4>
                                                </div>
                                                <div>
                                                    <small>
                                                    <?php
                                                        echo $label = Yii::t('app', '{n,plural,=0{} =1{ 1 día programado} other{# días programados}}', ['n' => $item->nro_dias ]);
                                                    ?>
                                                    </small>
                                                </div>
                                                <div>
                                                    <p class="text-justify">
                                                        <?= Html::encode($item->descripcion) ?>
                                                    </p>
                                                </div>
                                                <hr>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="<?=Url::toRoute(['site/consultar-curso'])?>" class="btnPanelListAdd consultar-curso"  style=" position:relative; margin-top:25px; color:black">
                                        Consultar Por El Curso
                                    </a>
                                </div>
                                <div class="text-center">
                                    <a href="<?=Url::toRoute(['site/inscripcion'])?>" class="btnPanelListAdd inscripciones"  style=" position:relative; margin-top:25px; color:black">
                                        Inscribirse al Curso
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
