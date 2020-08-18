<?php
    use yii\helpers\Url;
    use app\models\Sucursal;
    use yii\helpers\StringHelper;

    $sucursales = Yii::$app->user->identity
        ->getSucursalesActivas()
        ->asArray();
?>

<?php if($sucursales->count() > 0): ?>
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
<?php endif; ?>

<li>
    <a data-role="open-modal" href="<?= Url::toRoute(['/docente/asistencia']);?>">
    
        <i class="fa fa-users fw"></i>
        <?=  Yii::t('app', 'Alumnos'); 	?>
    </a>
</li>
<li>
    <a data-role="open-modal" href="<?= Url::toRoute(['/docente/material-docente/estudiante']);?>">
    
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Descarga de Material'); 	?>
    </a>
</li>
<li>
    <a data-role="open-modal" href="<?= Url::toRoute(['/docente/material-docente']);?>">
    
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Material Docente'); ?>
    </a>
</li>
<li>
    <a data-role="open-modal" href="<?= Url::toRoute(['/docente/evaluacion']);?>">
    
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Evaluacion'); ?>
    </a>
</li>
<li>
    <a href="<?= Url::toRoute(['/docente/mensajes']);?>">
        <i class="fa fa-comment fw"></i>
        <?=  Yii::t('app', 'Mensaje'); 	?>
    </a>
</li>

<?php  return; ?>


<li>
    <a href="#ficha"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-cog fw"></i>
        <?=  Yii::t('app', 'Perfil'); ?>
    </a>
    <ul id="ficha" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/social']);  			?>" data-role="open-modal"><?=  Yii::t('app', 'Ficha Personal'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#alumnos"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-user fw"></i>
        <?=  Yii::t('app', 'Alumnos'); ?>
    </a>
    <ul id="alumnos" class="collapse">
        <li><a href="<?= Url::toRoute(['/usuarios/estudiante/create']);     ?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Alumno'); 		?></a></li>
        <li><a href="<?= Url::toRoute(['/usuarios/estudiante/index']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#material"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Descarga Material'); ?>
    </a>
    <ul id="material" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Material'); 	?></a></li>

        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#material2"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-download fw"></i>
        <?=  Yii::t('app', 'Material Docente'); ?>
    </a>
    <ul id="material2" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Material'); 	?></a></li>

        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#material3"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-comment fw"></i>
        <?=  Yii::t('app', 'Mensajes'); ?>
    </a>
    <ul id="material3" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Mensajes'); 	?></a></li>
    </ul>
</li>
