<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<!--model-->
<div id="modal" class="modal" tabindex="false" role="dialog">
     <div class="modal-dialog" role="alert">
     <div class="modal-content">
         <div class="modal-body">
         </div>
     </div>
     </div>
 </div>
 <!--modal-->

 <!--inicio div popup inicial-->

 <?=
Html::img(Yii::getAlias('@web/images/guest/cross.png'),[
 'alt'    => Yii::$app->name,
 'title'  => Yii::$app->name,
 'id'=> 'imgPopUpCross',
 'class'=>'curPointer',
 'style'=> ' position: absolute; cursor: pointer;top: 30px;RIGHT: 1px;z-index: 999999999999; width: 40px;'
]);
?>
 <div class="" id="divOverlay" style="background: #00000094;    width: 100%;    height: 100%;    top: 0px;    position: fixed;z-index: 99999;/*display:none;*/"></div>
 <div id="divPopUpInicial" style="position: absolute;top: 84px;z-index: 9999999;width: 100%;/* left: 35%; */height: 50vh;">
     <div style="position: relative;width: 100%;max-height: 100%;">
         <iframe class="center-block" id="iframeYoutubePopUpInicial" width="711" height="402" style=" border-width: 0;" src="<?=$config[0]['youtube']?>">
         </iframe>
     </div>
 </div>
 <!--fin del poppup-->


 <!--

     inicio div del contenido del sistema
 -->


<!--inicio del div quienes somoms-->
<div class="divQuienesSomos hide">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class=" text-uppercase text-center" style=" color:black;">¿Quiénes somos?</h2>
                <?=
                Html::img(Yii::getAlias('@web/images/guest/linea-negra.png'),[
                    'alt'    => Yii::$app->name,
                    'title'  => Yii::$app->name,
                    'style'=> 'margin-bottom: 10px;',
                    'class'=> 'img img-responsive mbot-30 center-block'
                ]);
                ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style="color:black">

                        <p>Leo Paparella y su equipo de profesionales apuestan al futuro y trabajan constantemente en el concepto de la excelencia. </p>

                        <p>En 1970, después de trabajar con el prestigioso coiffeur Andrea Paparella, abrió junto a sus hermanos Pino y Lina, su primer salón en el barrio de Recoleta, Buenos Aires. </p>

                        <p>Años más tarde, luego de un contundente éxito, se mudaron, por el mismo barrio, a un elegante petit hotel, originario de 1910, el cual fue convertido en la casa central y funcionó como uno de los salones de belleza más importantes del país. </p>

                        <p>Por los salones pasaron importantes personalidas como Charlton Heston, Ornella Muti, Chatérine Deneuve, Ivana Trump, Iva Zanecchi y Diana D´Orléans, entres otras. </p>

                        <p>Hoy seguimos apostando a la profesión y también nos dedicamos a formar profesionales con una noción integraldel negocio.</p>
                        
                        <p>Brindarles herramientas técnicas, artísticas y de gestión con el fin de que puedan desarrollar sus propias empresas o formar parte de equipos de profesionales cuyo principal objetivo este puesto en la satisfacción del cliente. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!--fin del del div quienes somomos-->



 <!--inid div curso detalles-->

 <div class="divCursoDetalles hide">
     <section id="sectionCursoDetalle" class="section-black whiteBackground viewFront notShow" style="display: block;">
         <div class="container clearfix text-center">
             <div class="row">
             <div class="col-md-12">
                 <h2 class=" text-uppercase"></h2>
                 <div class="row">
                 <div style=" color: black;">
                 <div id="divCursoDetalle">
                 <div style="display: inline-block;">
                 <?=
                   Html::img(Yii::getAlias('@web/images/guest/cursos/bEsMIbOb.jpg'),[
                     'alt'    => Yii::$app->name,
                     'title'  => Yii::$app->name,
                     'id'     => 'divCursoDetalleImagen',
                     'style'=> ' width:700px;',
                     'class'=> 'imgCurso'
                   ]);
                  ?>
                 </div> <div  style="     display: inline-block; vertical-align: top;  width: 278px;    margin-left: 37px; ">
                 <div class="" id="divCursoDetalleTitulo" style=" font-weight:bold;margin-bottom:30px; font-size:16px;">CARRERA DE MANICURIA PROFESIONAL</div>
                 <div class="" id="divCursoDetalleContenido" style=" text-align:left;">•  Paso a paso Técnica de limado<br> •  Esmaltado perfecto Manicuria masculina Esmaltado semi permanente y seco</div>
                 <br>
                 <div style=" text-align:left;">
                     <div class="btnPanelListAdd" id="btnCursoConsultar" style=" position:relative; margin-top:25px;     padding: 10px; border: 1px solid #aaaaaa;">Consultar por el Curso</div>
                     <br>
                     <div class="btnPanelListAdd" id="btnCursoInscribirse" style=" position:relative; margin-top:25px;     padding: 10px; border: 1px solid #aaaaaa;">Inscribirse al Curso</div>
                 </div>
                 </div>
                 </div>
                 </div>
                 </div>
             </div>
             </div>
         </div>
     </section>
 </div>
 <!--fin del div cuersos detaller-->

 <!--inicio div sucursale-->
 <div class="divSucursales hide">
     <div class="row">
         <div class="col-md-12 text-center">
            <h2 class=" text-uppercase" style=" color:black;">Sucursales</h2>
            <?=
                Html::img(Yii::getAlias('@web/images/guest/linea-negra.png'),[
                    'alt'    => Yii::$app->name,
                    'title'  => Yii::$app->name,
                    'class'=> 'img img-responsive mbot-30 center-block'
                ]);
            ?>

            <?php
                if(count($sucursales) > 0) :
                foreach ($sucursales as $sucursal): ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style=" color: black;">
                        <div class="" id="divFranquiciasFront" style=" margin-top:25px; font-size: 15px;">
                            <div class="" style=" margin-bottom:50px;" id="">
                                <b>
                                    <div style=" margin-bottom:15px; text-transform:uppercase"><?= $sucursal['nombre'];?></div>
                                </b>
                                <div style=" margin-bottom:15px;"><?= $sucursal['direccion'];?></div>
                                <div style=" margin-bottom:15px;">
                                    <?php
                                        if(!empty($sucursal['numero1']))
                                        {
                                            echo 'Tel : '.$sucursal['numero1'];
                                            if(!empty($sucursal['extension1']))
                                                echo ' Ext: '.$sucursal['extension1'];

                                            echo '<br>';
                                        }

                                        if(!empty($sucursal['numero2']))
                                        {
                                            echo 'Tel : '.$sucursal['numero2'];
                                            if(!empty($sucursal['extension2']))
                                                echo ' Ext: '.$sucursal['extension2'];

                                            echo '<br>';
                                        }
                                    ?>
                                </div>
                                <div style=" margin-bottom:15px;"><?= $sucursal['email'];?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            else :
                ?>
                <h2 class='text-danger'>Debes registrar Sucursales</h2>
                <?php
            endif;

         ?>

         </div>
     </div>
 </div>

 <!--fin del div sucursales-->


 <!--
     fin del div
 -->
<div class="main" id="main">
 <div class="container">

     <?=
       Html::img(Yii::getAlias('@web/images/guest/inicio_web.jpg'),[
         'alt'    => Yii::$app->name,
         'title'  => Yii::$app->name,
         'class'=>'img img-responsive imgInicioWeb',
       ]);
     ?>
     <h1 class="regular" style=" color: black;margin-bottom: 5px;font-size: 17px;"> SEGUINOS EN NUESTRAS REDES SOCIALES </h1>
     <div class="redessociales_negras">
         <h1 class="regular" id="lnkFrontFacebook" style="cursor:pointer; color: black;margin-top: 5px; display:inline-block;     margin-right: 13px;">

                  <?= Html::a(Html::img(Yii::getAlias('@web/images/guest/f_logo_black.png'),
                  [
                    'alt'=> Yii::$app->name,
                    'title'  => Yii::$app->name,
                     'style'=> 'width:30px;'
                  ]),$config[0]['facebook']);
                  ?>
         </h1>
         <h1 class="regular" id="lnkFrontInsta" style="cursor:pointer; color: black;margin-top: 5px; display:inline-block;margin-left: 13px;">
              <?= Html::a(Html::img(Yii::getAlias('@web/images/guest/insta_logo_black.jpg'),
              [
                'alt'=> Yii::$app->name,
                'title'  => Yii::$app->name,
                 'style'=> 'width:30px;',

              ]),$config[0]['instagram']);
              ?>
         </h1>
     </div>
 </div>
</div>
