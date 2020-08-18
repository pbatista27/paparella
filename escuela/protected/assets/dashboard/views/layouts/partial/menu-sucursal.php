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

<?php  return; ?>


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
    <a href="#profesores"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-cog fw"></i>
        <?=  Yii::t('app', 'Profesores'); ?>
    </a>
    <ul id="profesores" class="collapse">
        <li><a href="<?= Url::toRoute(['/usuarios/docente/create']);     ?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Docente'); 		?></a></li>
        <li><a href="<?= Url::toRoute(['/usuarios/docente/index']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>

<li>
    <a href="#control-pago"  data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-history fw"></i>
        <?=  Yii::t('app', 'Control de Pago'); ?>
    </a>
    <ul id="control-pago" class="collapse">
        <li><a href="<?= Url::toRoute(['/controlpago/sucursal/create']);    ?>" data-role="open-modal"><?= Yii::t('app', 'Registrar Pago'); ?></a></li>
        <li><a href="<?= Url::toRoute(['/controlpago/docente/create']);     ?>" data-role="open-modal"><?= Yii::t('app', 'Listado'); 		 ?></a></li>
        <li><a href="<?= Url::toRoute(['/controlpago/estudiante/create']);  ?>" data-role="open-modal"><?= Yii::t('app', 'Estadisticas'); 	 ?></a></li>
    </ul>
</li>

<li>
	<a href="#cursadas" data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-star fw"></i>
		<?=  Yii::t('app', 'Cursadas'); ?>
	</a>

	<ul id="cursadas" class="collapse">
        <li><a href="<?= Url::toRoute(['/configuracion/default/social']);  			?>" data-role="open-modal"><?=  Yii::t('app', 'Nueva Cursada'); 	?></a></li>
        <li><a href="<?= Url::toRoute(['/configuracion/default/youtube']); 			?>" data-role="open-modal"><?=  Yii::t('app', 'Listado'); 	?></a></li>
    </ul>
</li>


