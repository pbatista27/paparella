<?php
    use Yii;
	use yii\helpers\Url;
    use app\models\Sucursal;
    use app\models\UsuarioSucursal;
    use yii\helpers\StringHelper;

   /* $sucursales = Yii::$app->user->identity
        ->getSucursalesActivas()
        ->asArray();*/

?>

<?php /* if($sucursales->count() > 0): ?>
<li>
    <a href="#sucursales"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-institution fw"></i>
        <?=  Yii::t('app', 'Mis Sucursales'); ?>
    </a>

    <ul id="sucursales" class="collapse">
        <?php
            foreach($sucursales->all() as $item ):
                $item = (object) $item;
        ?>
        <li>
            <a href="<?= Url::toRoute(['/sucursales/default/view', 'id'=> $item->id ]); ?>">
               <?= StringHelper::truncate($item->nombre,15); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</li>
<?php endif; */?>
<!--
<li>
    <a href="<?= Url::toRoute(['/mi-cuenta/']);?>">
    
        <i class="fa fa-cog fw"></i>
        <?=  Yii::t('app', 'Perfil'); 	?>
    </a>
</li>-->
<li>
    <a data-role='open-modal' href="<?= Url::toRoute(['/estudiante/material']);?>">
    
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Descarga de Material'); 	?>
    </a>
</li>
<li>
    <a data-role='open-modal' href="<?= Url::toRoute(['/estudiante/evaluacion']);?>">
    
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Descarga Evaluacion'); ?>
    </a>
</li>
<li>
    <a data-role='open-modal' href="<?= Url::toRoute(['/estudiante/subir-archivo/']);?>">
        <i class="fa fa-upload fw"></i>
        <?=  Yii::t('app', 'Subir Examen'); 	?>
    </a>
</li>
<?php if(Yii::$app->user->identity->getUsuarioSucursals()->count() > 0) : ?>
<li>
    <a data-role="open-modal" href="<?= Url::toRoute(['/estudiante/']);?>">
        <i class="fa fa-comment fw"></i>
        <?=  Yii::t('app', 'Dejanos tu opinión'); 	?>
    </a>
</li>
<?php endif;?>
<li>
    <a href="<?= Url::toRoute(['/estudiante/mensajes']);?>">
        <i class="fa fa-comment fw"></i>
        <?=  Yii::t('app', 'Mensaje'); 	?>
    </a>
</li>
<?php
return;
?>


<li>
    <a href="#ficha"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-cog fw"></i>
        <?=  Yii::t('app', 'Perfil'); ?>
    </a>
    <ul id="ficha" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/social']);?>" data-role="open-modal"><?=  Yii::t('app', 'Ficha Personal'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#material"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Descarga Material'); ?>
    </a>
    <ul id="material" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']);?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#examen"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Examenes'); ?>
    </a>
    <ul id="examen" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']);?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Examen'); 	?></a></li>

        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']);?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#programa"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Programas'); ?>
    </a>
    <ul id="programa" class="collapse">
       <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']);?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="<?= Url::toRoute(['/encuestas/default/search']);?>" data-role="open-modal">
        <i class="fa fa-line-chart  fw"></i>
        <?= Yii::t('app', 'Encuestas'); ?>
    </a>

</li>

<li>
    <a href="#material3"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-comment fw"></i>
        <?=  Yii::t('app', 'Mensajes'); ?>
    </a>
    <ul id="material3" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']);?>" data-role="open-modal"><?=  Yii::t('app', 'Mensajes'); 	?></a></li>
    </ul>
</li>
