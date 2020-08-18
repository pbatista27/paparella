<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!--inicio del div carreras o cursos-->
<div class="divCarrerasCursos" id="divCarrerasCursos">
     <div class="row">
         <div class="col-md-12 text-center">
             <h2 class=" text-uppercase" style=" color:black;    margin-top: 37px;">Cursos</h2>
             <?=
               Html::img(Yii::getAlias('@web/images/guest/linea-negra.png'),[
                 'alt'    => Yii::$app->name,
                 'title'  => Yii::$app->name,
                 'style'=> 'margin-bottom: 0px;',
                 'class'=> 'img img-responsive mbot-30 center-block'
               ]);
              ?>

              <?php
                if(count($model) >= 0) {
              foreach ($model as $curso):  ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style=" color: black;">
                        <div class="content2">
                            <div id="divCursosFront" class="loaded">
                                <div style=" text-align:center;padding-bottom: 1px;" class="cursoItem" data-url='<?=Url::toRoute('/site/curso-detalle');?>' data-id="<?=$curso['id'];?>">
                                    <h3>
                                        <div class="divTitulo" id="" style=" margin-top:25px;    text-transform: uppercase;"><?=$curso['nombre']?></div>
                                        <?=
                                        Html::img($curso->getImage(),[
                                            'alt'    => Yii::$app->name,
                                            'title'  => Yii::$app->name,
                                            'style'=> 'margin-top: 32px; width:350px; display: inline-block;',
                                            'class'=> 'imgCurso'
                                        ]);
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
              <?php  endforeach;
                }
                else {
                    ?>
                    <br><br>
                    <h3 class="text-center text-danger">NO HAY CURSOS </h3>
                    <?php
                }
              ?>
              <br> <br>
         </div>
     </div>
 </div>
 <br><br>

 <!--fin del div carreras o cursos-->
