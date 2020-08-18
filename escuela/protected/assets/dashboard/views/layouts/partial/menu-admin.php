<?php
    use yii\helpers\Url;
    use yii\helpers\StringHelper;

    use app\models\Sucursal;
    use app\models\Curso;

    $sucursales = Sucursal::find()->where('activo = 1');
	$cursos 	= Curso::find()->where('activo = 1 and is_tmp = 0');
?>
<!--menu config-->
<li>
	<a href="#configuracion"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-cog fw"></i>
		<?=  Yii::t('app', 'Configuracion de sitio'); ?>
	</a>
	<ul id="configuracion" class="collapse">
		<li><a data-role="open-modal" href="<?= Url::toRoute(['/admin-configuracion/default/social']);  ?>" ><?=  Yii::t('app', 'Redes sociales'); 	 ?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute(['/admin-configuracion/default/video']);   ?>" ><?=  Yii::t('app', 'Video promocional'); ?></a></li>
		<!-- <li><a href="<?= Url::toRoute(['/inscripciones/index']); ?>"><?=  Yii::t('app', 'Pre-inscripciones-online'); 	 ?></a></li> -->
    </ul>
</li>

<!--menu sucursal-->
<li>
	<a href="#sucursales"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-institution fw"></i>
		<?=  Yii::t('app', 'Sucursales'); ?>
	</a>
	<ul id="sucursales" class="collapse">
		<li><a href="<?= Url::toRoute(['/admin-sucursales/default/create']); ?>" /*data-role="open-modal"*/ ><?=  Yii::t('app', 'Nueva'); 	?></a></li>
		<li><a href="<?= Url::toRoute(['/admin-sucursales/default/index']);  ?>" /*data-role="open-modal"*/ ><?=  Yii::t('app', 'Administrar todas'); 	?></a></li>
		<?php
			$count = $sucursales->count();
			if($count > 0):
		?>
		<li>
			<a href="#menu-sucursal-activas" data-toggle="collapse" class="parent collapsed">
				<?=
					Yii::t('app', 'Activas ({num})', [ 'num' => $count ]);
				?>
			</a>
			<ul id="menu-sucursal-activas" class="collapse">
        		<?php
            		foreach($sucursales->all() as $item ):
                	$item = (object) $item;
                ?>
				<li><a href="<?= Url::toRoute(['/admin-sucursales/default/view', 'id'=> $item->id ]); ?>"><?= StringHelper::truncate($item->nombre,15); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php
			endif;
		?>
    </ul>
</li>

<!--menu cursos-->
<li>
	<a href="#cursos"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-file-text-o  fw"></i>
		<?=  Yii::t('app', 'Cursos'); ?>
	</a>
	<ul id="cursos" class="collapse">
		<li><a href="<?= Url::toRoute(['/admin-cursos/create/index']);  ?>" ><?=  Yii::t('app', 'Nuevo'); 	?></a></li>
		<li><a href="<?= Url::toRoute(['/admin-cursos/default/index']); ?>" ><?=  Yii::t('app', 'Administrar todos'); 	?></a></li>
		<?php
			$count = $cursos->count();
			if($count > 0):
		?>
		<li>
			<a href="#menu-cursos-activos" data-toggle="collapse" class="parent collapsed">
				<?=
					Yii::t('app', 'Activos ({num})', [ 'num' => $count ]);
				?>
			</a>
			<ul id="menu-cursos-activos" class="collapse">
        		<?php
            		foreach($cursos->all() as $item ):
                ?>
				<li><a href="<?= Url::toRoute(['/admin-cursos/default/update', 'id'=> $item->id ]); ?>"><?= StringHelper::truncate($item->nombre,15); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php
			endif;
		?>
    </ul>
</li>

<!--menu personal -->
<li>
	<a href="#personal"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-users  fw"></i>
		<?=  Yii::t('app', 'Personal administrativo'); ?>
	</a>
	<ul id="personal" class="collapse">
		<li><a href="<?= Url::toRoute(['/admin-personal/administradores/create']);  ?>" ><?=  Yii::t('app', 'Nuevo Administrador S.'); ?></a></li>
		<li><a href="<?= Url::toRoute(['/admin-personal/docentes/create']);  		?>" ><?=  Yii::t('app', 'Nuevo Docente'); 		?></a></li>
		<li><a href="<?= Url::toRoute(['/admin-personal/default/index']); 			?>" ><?=  Yii::t('app', 'Administrar todos'); 	?></a></li>
    </ul>
</li>

<?php return; ?>




















<li>
	<a href="#usuarios"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-user-plus fw"></i>
		<?=  Yii::t('app', 'usuarios'); ?>
	</a>
	<ul id="usuarios" class="collapse">
		<li><a href="<?= Url::toRoute(['/usuarios/sucursal/create']);    ?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Admin Sucursal'); ?></a></li>
		<li><a href="<?= Url::toRoute(['/usuarios/docente/create']);     ?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Docente'); 		?></a></li>
		<li><a href="<?= Url::toRoute(['/usuarios/estudiante/create']);  ?>" data-role="open-modal"><?=  Yii::t('app', 'Nuevo Estudiante'); 	?></a></li>
    </ul>
</li>

<li>
	<a href="#control-pago"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-history fw"></i>
		<?=  Yii::t('app', 'Control de Pago'); ?>
	</a>
	<ul id="control-pago" class="collapse">
		<li><a href="<?= Url::toRoute(['/control-pago/sucursal/create']);    ?>" data-role="open-modal"><?= Yii::t('app', 'Registrar Pago'); ?></a></li>
		<li><a href="<?= Url::toRoute(['/control-pago/docente/create']);     ?>" data-role="open-modal"><?= Yii::t('app', 'Listado'); 		 ?></a></li>
		<li><a href="<?= Url::toRoute(['/control-pago/estudiante/create']);  ?>" data-role="open-modal"><?= Yii::t('app', 'Estadisticas'); 	 ?></a></li>
    </ul>
</li>

<li>
	<a href="<?= Url::toRoute(['/encuestas/default/search']); ?>" data-role="open-modal">
		<i class="fa fa-line-chart  fw"></i>
		<?= Yii::t('app', 'Encuestas'); ?>
	</a>

	<ul id="catalog-submenu3" class="collapse">
		<li><a href="<?= Url::toRoute(['users/create']); ?>"> <?=  Yii::t('app', 'Crear Usuario'); 	?></a></li>
		<li><a href="<?= Url::toRoute(['users/index']); ?>"> <?=  Yii::t('app', 'Listar Usuarios'); 	?></a></li>
	</ul>
</li>

<li>
	<a href="#catalog-submenu4" data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-user-plus  fw"></i>
		<?=  Yii::t('app', 'Menu Profesores'); ?>
	</a>

	<ul id="catalog-submenu4" class="collapse">
		<li><a href="<?= Url::toRoute(['profesores/create']); ?>"> <?=  Yii::t('app', 'Crear Profesor'); 	?></a></li>
		<li><a href="<?= Url::toRoute(['profesores/index']); ?>"> <?=  Yii::t('app', 'Listar Profesores'); 	?></a></li>
	</ul>
</li>

<li>
	<a href="#catalog-submenu5" data-toggle="collapse" class="parent collapsed">
        <i class="fa fa-user fw"></i>
		<?=  Yii::t('app', 'Menu Estudiantes'); ?>
	</a>

	<ul id="catalog-submenu5" class="collapse">
		<li><a href="<?= Url::toRoute('#'); ?>"> <?=  Yii::t('app', 'Crear Estudiante'); 	?></a></li>
		<li><a href="<?= Url::toRoute('#'); ?>"> <?=  Yii::t('app', 'Listar Estudiantes'); 	?></a></li>
	</ul>
</li>

<li>
	<a href="#catalog-submenu6" data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-money fw"></i>
		<?=  Yii::t('app', 'Menu Pagos'); ?>
	</a>

	<ul id="catalog-submenu6" class="collapse">
		<li><a href="<?= Url::toRoute(['curseras-pagos/create']); ?>"> <?=  Yii::t('app', 'Crear Pago'); 	?></a></li>
		<li><a href="<?= Url::toRoute(['curseras-pagos/index']); ?>"> <?=  Yii::t('app', 'Listar Pagos'); 	?></a></li>
	</ul>
</li>

