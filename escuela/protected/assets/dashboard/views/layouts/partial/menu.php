<?php
    use yii\helpers\Url;
    use yii\helpers\StringHelper;
    use app\models\Sucursal;
    use app\models\Curso;

    $user 			= Yii::$app->user->identity;
	$dahoboardHome  = $user->dashboardHome();
    $sucursales 	= $user->querySucursales()->andWhere('sucursal.activo = 1')->orderBy('nombre asc');
	$cursos 		= Curso::find()->where('activo = 1 and is_tmp = 0');
	$prefixRoute    = $user->prefixProfileModule;
?>

<?php if($dahoboardHome): ?>
<!--menu de estadisticas por perfil-->
<li>
	<a href="<?= $user->dashboardHome();  ?>">
		<i class="fa fa-pie-chart fw"></i>
		<?=  Yii::t('app', 'Panel administrativo'); ?>
	</a>
</li>
<?php endif; ?>

<?php if($user->isAdmin()): ?>
<!--menu de configuracion-->
<li>
	<a href="#configuracion"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-cog fw"></i>
		<?=  Yii::t('app', 'Configuracion de sitio'); ?>
	</a>
	<ul id="configuracion" class="collapse">
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute .'/configuracion/redes-sociales']);    ?>" ><?=  Yii::t('app', 'Redes sociales'); 	 ?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute .'/configuracion/video-promocional']); ?>" ><?=  Yii::t('app', 'Video promocional'); ?></a></li>
    </ul>
</li>
<?php endif; ?>


<?php if($user->isAdmin()): ?>
<!--menu de sucursales-->
<li>
	<a href="#sucursales"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-institution fw"></i>
		<?=  Yii::t('app', 'Sucursales'); ?>
	</a>
	<ul id="sucursales" class="collapse">
		<?php if($user->isAdmin()) : ?>
		<li><a href="<?= Url::toRoute([$prefixRoute . '/sucursales/create']); ?>" ><?=  Yii::t('app', 'Nueva'); ?></a></li>
		<?php endif; ?>
		<li><a href="<?= Url::toRoute([$prefixRoute . '/sucursales/index']);  ?>" ><?=  Yii::t('app', 'Administrar todas'); ?></a></li>

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
				<li><a href="<?= Url::toRoute([$prefixRoute . '/sucursales/view', 'id'=> $item->id ]); ?>"><?= StringHelper::truncate($item->nombre,15); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php
			endif;
		?>
    </ul>
</li>
<?php endif; ?>


<?php if($user->isAdminSucursal() and ($sucursales->count() > 0) ): ?>
<!--menu de sucursales-->
<li>
	<a href="#sucursales"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-institution fw"></i>
		<?=  Yii::t('app', 'Sucursales'); ?>
	</a>
	<ul id="sucursales" class="collapse">
		<?php
			foreach($sucursales->all() as $item ):
			$item = (object) $item;
		?>
		<li><a href="<?= Url::toRoute([$prefixRoute . '/sucursales/view', 'id'=> $item->id ]); ?>"><?= StringHelper::truncate($item->nombre,15); ?></a></li>
		<?php endforeach; ?>
	</ul>
</li>
<?php endif; ?>


<?php if($user->isAdmin() /*|| $user->isAdminSucursal() */ ): ?>
<!--menu de administracion de personal-->
<li>
	<a href="#personal"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-users  fw"></i>
		<?=  Yii::t('app', 'Personal administrativo'); ?>
	</a>
	<ul id="personal" class="collapse">
		<?php if($user->isAdmin()): ?>
		<li><a href="<?= Url::toRoute([ $prefixRoute . '/personal-administrativo/admin-create']); ?>" ><?=  Yii::t('app', 'Nuevo Administrador'); ?></a></li>
		<?php endif; ?>
		<li><a href="<?= Url::toRoute([ $prefixRoute . '/personal-administrativo/doc-create']);   ?>" ><?=  Yii::t('app', 'Nuevo Docente'); 		?></a></li>
		<li><a href="<?= Url::toRoute([ $prefixRoute . '/personal-administrativo/index']); 		  ?>" ><?=  Yii::t('app', 'Administrar todos'); 	?></a></li>
    </ul>
</li>
<?php endif; ?>


<?php if($user->isAdmin()): ?>
<!--menu cursos-->
<li>
	<a href="#cursos"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-file-text-o  fw"></i>
		<?=  Yii::t('app', 'Cursos'); ?>
	</a>
	<ul id="cursos" class="collapse">
		<li><a href="<?= Url::toRoute(['/cursos/create/index']);  ?>" ><?=  Yii::t('app', 'Nuevo'); 	?></a></li>
		<li><a href="<?= Url::toRoute(['/cursos/default/index']);   ?>" ><?=  Yii::t('app', 'Administrar todos'); 	?></a></li>
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
				<li>
					<a href="<?= Url::toRoute(['/cursos/default/update', 'id'=> $item->id ]); ?>">
						<?= StringHelper::truncate($item->nombre,15); ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php
			endif;
		?>
    </ul>
</li>
<?php endif; ?>

<?php if($user->isAdmin() || $user->isAdminSucursal()): ?>
<!--menu de Estudiantes-->
<li>
	<a href="#estudiantes"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-graduation-cap fw"></i>
		<?=  Yii::t('app', 'Estudiantes'); ?>
	</a>
	<ul id="estudiantes" class="collapse">
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/estudiantes/create']);?>" ><?=  Yii::t('app', 'Nuevo ingreso'); 		?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/estudiantes/search']);?>" ><?=  Yii::t('app', 'Busqueda'); 			?></a></li>
		<li><a                        href="<?= Url::toRoute([ $prefixRoute . '/estudiantes/index']);?>"  ><?=  Yii::t('app', 'Administrar todos'); 	?></a></li>
    </ul>
</li>
<?php endif; ?>

<?php if($user->isAdmin() || $user->isAdminSucursal()): ?>
<!--menu de Pre-inscripciones-->
<li>
	<a href="#preisncripciones"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-user-plus fw"></i>
		<?=  Yii::t('app', 'Pre-inscripciones'); ?>
	</a>
	<ul id="preisncripciones" class="collapse">
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pre-inscripciones/create']);?>" ><?=  Yii::t('app', 'Estudiantes inscritos');	?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pre-inscripciones/create']);?>" ><?=  Yii::t('app', 'Solitud nuevo ingreso');	?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pre-inscripciones/search']);?>" ><?=  Yii::t('app', 'Busqueda'); 				?></a></li>
		<li><a                        href="<?= Url::toRoute([ $prefixRoute . '/pre-inscripciones/index']);?>"  ><?=  Yii::t('app', 'Administrar todos'); 	?></a></li>
    </ul>
</li>
<?php endif; ?>

<?php if($user->isAdmin() || $user->isAdminSucursal()): ?>
<!--menu de Pagos-->
<li>
	<a href="#pagos"  data-toggle="collapse" class="parent collapsed">
		<i class="fa fa-handshake-o fw"></i>
		<?=  Yii::t('app', 'Menu de pagos'); ?>
	</a>
	<ul id="pagos" class="collapse">
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pagos/create']);?>"   	 ><?=  Yii::t('app', 'Registrar un pago'); 		  ?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pagos/devolucion']);?>"  ><?=  Yii::t('app', 'Registrar una devolución'); ?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pagos/vencidos']);?>" 	 ><?=  Yii::t('app', 'Pagos vencidos'); 	  	  ?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pagos/completados']);?>" ><?=  Yii::t('app', 'Pagos completados'); 		  ?></a></li>
		<li><a data-role="open-modal" href="<?= Url::toRoute([ $prefixRoute . '/pagos/search']);?>"   	 ><?=  Yii::t('app', 'Busqueda'); 		  		  ?></a></li>
		<li><a                        href="<?= Url::toRoute([ $prefixRoute . '/pagos/index']);?>"   	 ><?=  Yii::t('app', 'Administrar Todos'); 		  ?></a></li>
    </ul>
</li>
<?php endif; ?>

<?php if($dahoboardHome): ?>
<!--menu de -->
<li>
	<a href="<?= $user->dashboardHome();  ?>">
		<i class="fa fa-pie-chart fw"></i>
		<?=  Yii::t('app', 'Panel administrativo'); ?>
	</a>
</li>
<?php endif; ?>

