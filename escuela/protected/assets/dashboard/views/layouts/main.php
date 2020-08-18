<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
  //  use app\assets\dashboard\DashoardAsset;
    use app\assets\dashboard\GuestAsset;
  //  DashoardAsset::register($this);
  use app\models\Config;
  use app\models\Newsletter;

  // usando los modelos
  $newsletter = new Newsletter();
  $config = Config::find()->All();
  if(count($config)<=0)
  {
      $config[0]['nombre'] = 'Escuela Leopaparella';
      $config[0]['facebook'] = 'https://www.facebook.com/Escuela-Leo-Paparella-934184929955798/';
      $config[0]['youtube'] = 'https://www.youtube.com/embed/4Uxb_CHTVL0?autoplay=1';
      $config[0]['instagram'] = 'https://www.instagram.com/escuelaleopaparella/';
      $config[0]['quienes_somos'] = '<h3>Debes agregar quienes somos</h3>';
      $config[0]['max_calificacion'] = '100';
      $config[0]['min_calificacion'] = '70';

  }
  GuestAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="container-fluid" style='margin-top: 100px !important;padding: 0px;'>
        <?php $this->beginBody();   ?>
        <nav class="navbar navbar navbar-fixed-top">
       <div class="bartop">
           <div class="redessociales">
                <?= Html::a(Html::img(Yii::getAlias('@web/images/guest/f_logo_white.png'),
                [
                  'alt'=> Yii::$app->name,
                  'title'  => Yii::$app->name,
                ]),$config[0]['facebook']);
                ?>

                <?= Html::a(Html::img(Yii::getAlias('@web/images/guest/insta_logo_white.png'),
                [
                  'alt'=> Yii::$app->name,
                  'title'  => Yii::$app->name,
                ]),$config[0]['instagram']);
                ?>
           </div>
       </div>
       <div class="container">
         <div class="navbar-header">
           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
           <a class="navbar-brand" href="<?=Url::toRoute(['site/index']);?>">
               <?=
                 Html::img(Yii::getAlias('@web/images/guest/logo_navbar2.png'),[
                   'alt'    => Yii::$app->name,
                   'title'  => Yii::$app->name,
                   'class' => 'img img-responsive'
                 ]);
                ?>
           </a>
         </div>
         <div id="navbar" class="navbar-collapse collapse">
           <ul class="nav navbar-nav">
             <li><a href="<?=Url::toRoute(['site/index']);?>">INICIO</a></li>
             <li><a class='inscripciones' href="<?=Url::toRoute(['site/inscripcion'])?>">INSCRIPCION ONLINE</a></li>
             <li><a id='quienesSomos' href="#quienesSomos">QUIENES SOMOS</a></li>
             <li><a id='sucursales' href="#sucursales">SUCURSALES</a></li>
             <li><a id='carrerasCursos' href="<?=Url::toRoute(['site/carreras-cursos'])?>">CARRERAS / CURSOS</a></li>
             <li><a id='newsLetter' href="#newsletter">NEWSLETTER</a></li>
             <li><a id='login' href="<?=Url::toRoute(['site/login']);?>">INGRESAR</a></li>
           </ul>
         </div><!--/.nav-collapse -->
       </div>
   </nav>

        <div class="margin-v-15">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo Alert::widget(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $content;?>
        <footer class="footer">
       <div class="container">
           <h2 class=" text-uppercase">Suscribirse al Newsletter</h2>
           <div class="" id="" style=" overflow: hidden;text-align: center;">

            <div class="col-md-3"></div>
            <div class="col-md-6">
              <div class="container-fluid">
               <?php $form = ActiveForm::begin([
                  'id'=>$newsletter->formName(),
                  'action' => Url::toRoute(['/newsletter/create']),
                  'enableClientValidation'=>false,
                  'enableAjaxValidation'=>true,
                  'validationUrl'=>Url::toRoute('/newsletter/validar-crear-ajax'),
               ]);?>
               <div class="row">
                  <div class="col-md-6">
                      <?=$form->field($newsletter,'nombre')->textInput(['placeholder'=>'nombre'])->Label('Nombre');?>
                  </div>
                  <div class="col-md-6">
                      <?=$form->field($newsletter,'apellido')->textInput(['placeholder'=>'Apellido'])->Label('Apellido');?>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <?=$form->field($newsletter,'email')->textInput(['placeholder'=>'Email'])->Label('Email');?>
                  </div>
                  <div class="col-md-6">
                     <?=$form->field($newsletter,'telefono')->textInput(['placeholder'=>'telefono'])->Label('Telefono');?>
                  </div>
               </div>
               <div class="row">
                 <div class="col-md-12">
                    <div class="text-center">
                      <?= Html::submitButton('Enviar', ['class' => 'btn btn-block', 'style'=>' width: 300px; height: 45px;  margin-top:28px;  display: inline-block;border:1px solid black; background-color: white !important;']) ?>
                    </div>
                 </div>
               </div>
               <?php $form::end(); ?>
              </div>
            </div>
            <div class="col-md-3"></div>
       </div>
       <br><br>
   </footer>
        <?php $this->endBody();     ?>

    </body>
</html>
<?php $this->endPage() ?>
