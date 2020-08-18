 <?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\Json;
	use yii\helpers\ArrayHelper;
	use yii\widgets\Pjax;
	use base\widgets\faicons\Fa;
	use yii\bootstrap\ActiveForm;
	use kartik\date\DatePicker;
	use base\models\UserIdentity;

	Pjax::begin([
		'id'                => $this->context->pjaxId,
		'enablePushState'   => false,
	]);


	switch (true)
	{
		case ($this->context->action->perfil ==  UserIdentity::PROFILE_ADMIN_SUCURSAL):
			$prefixRoute = $this->context->currentController . '/administradores';
			break;

		case ($this->context->action->perfil ==  UserIdentity::PROFILE_DOCENTE):
			$prefixRoute = $this->context->currentController . '/docentes';
			break;
	}
?>

<div class="row" id="<?= $this->context->pjaxId; ?>">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<?php echo Fa::icon($this->iconClass)->fw(); ?>
					<?php echo $this->H1 ?>
				</h3>
			</div>
			<div class="panel-body" >
				<!--tob button add / delete-->
				<div class="padding-v-15" >
					<div class="clearfix">
						<div class="text-right">
							<?php
								echo Html::a(Yii::t('app', 'Nuevo registro'), Url::toRoute([ $prefixRoute . '-create', 'idSucursal' => $this->context->action->modelSucursal->id ]), [
									'class'     => 'btn btn-primary',
									'data-pjax' => 0,
									'data-role' => 'open-modal',
								]);
							?>
						</div>
					</div>
				</div>
				<!--navs-->
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#activos">
							<?php echo Fa::icon('check')->fw() .  Yii::t('app', 'activos') . ' ('. $data->actives->getTotalCount() .')' ?>
						</a>
					</li>

					<li>
						<a data-toggle="tab" href="#inactivas">
							<?php echo Fa::icon('times')->fw() .  Yii::t('app', 'Inactivos') . ' ('. $data->inactives->getTotalCount() .')' ?>
						</a>
					</li>
				</ul>

				<!--gridviews-->
				<div class="tab-content">
					<!--actives-->
					<div id="activos" class="tab-pane fade in active">
						<div id="grid-actives" class="container-fluid">
							<div class="row" >
								<div class="col-sx-12">
									<div class="padding-h-15">
										<div class="padding-top-5">
											<div class="table-responsive">
											<?php
												echo GridView::widget([
													'filterModel'   => $this->context->model,
													'dataProvider'  => $data->actives,
													'tableOptions'  => ['class' => 'table' ],
													'layout'        => '<div>{items}</div><div class="text-center">{pager}</div>',
													'columns'		=> [

														[
														    'class'    => 'yii\grid\ActionColumn',
														    'header'   => Yii::t('app', 'Habilitar'),
														    'visible'  => true,
														    'template' => '{btn}',
														    'contentOptions' => ['style' => 'width: 70px', 'class' => 'text-center'],
														    'buttons' => [
														        'btn' => function($url, $model, $key){

																	switch (true)
																	{
																		case ($this->context->action->perfil ==  UserIdentity::PROFILE_ADMIN_SUCURSAL):
																			$prefixRoute = $this->context->currentController . '/administradores';
																			break;

																		case ($this->context->action->perfil ==  UserIdentity::PROFILE_DOCENTE):
																			$prefixRoute = $this->context->currentController . '/docentes';
																			break;
																	}


														            $link = Url::toRoute([$prefixRoute .'-toggle-status', 'id' => $key ]);
														            $text = Fa::icon('times')->fw();
														            return Html::a($text, $link, [
														                'title'                 => Yii::t('app', 'Habilitar registro') ,
														                'class'                 => 'text-danger',
														                'data-pjax'             => 0,
														                'data-title-confirm'    => Yii::t('app', 'Habilitar registro'),
														                'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea habilitar este registro?'),
														                'data-runtime'          => 'ajax-confirm',
														                'data-label-btn-cancel' => Yii::t('yii', 'No'),
														                'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
														                'data-icon-class'       => 'fa fa-times',
														                'data-pjax-target'      => '#' . Yii::$app->controller->pjaxId,
														            ]);
														        },
														    ],
														],


														[
															'header' => 'Imagen',
															'format' => 'raw',
															'contentOptions' => ['style' => 'width: 50px', 'class' => 'text-center'],
															'value' => function($model){
																return Html::img( $model->getAvatar(),[
																	'style' => 'width:28px;margin:0 auto; display:block;'
																]);
															}
														],
														[
															'attribute' => 'nro_documento',
															'value' => function($model){
																return $model->getDNI();
															}
														],
														'nombres',
														'apellidos',
														'email',
														[
															'class'             => 'yii\grid\ActionColumn',
															'header'            => Yii::t('app', 'Acciones'),
															'contentOptions'    => ['style' => 'width: 100px', 'class' => 'text-center'],
															'template'          => '{update} {delete}',
															'buttons'   => [

																'update' => function ($url, $model, $key){

																	switch (true)
																	{
																		case ($this->context->action->perfil ==  UserIdentity::PROFILE_ADMIN_SUCURSAL):
																			$prefixRoute = $this->context->currentController . '/administradores';
																			break;

																		case ($this->context->action->perfil ==  UserIdentity::PROFILE_DOCENTE):
																			$prefixRoute = $this->context->currentController . '/docentes';
																			break;
																	}

																	$link = Url::toRoute([$prefixRoute . '-update' , 'id' => $key , 'idSucursal'=>  $this->context->action->modelSucursal->id ]);

																	return Html::a(Fa::icon('edit')->fw() , $link, [
																		'title'      =>  Yii::t('app', 'Actualizar registro') ,
																		'class'      => 'text-info',
																		'data-pjax'  => 0,
																		'data-role' => 'open-modal',
																	]);
																},


																'delete' => function ($url, $model, $key){

																	$link = Url::toRoute([ $this->context->currentController  .'/personal-delete', 'id' => $key, 'idSucursal' => Yii::$app->request->getQueryParam('idSucursal') ]);

																	return Html::a( Fa::icon('trash')->fw() , $link, [
																		'title'                 => Yii::t('app', 'Eliminar registro') ,
																		'class'                 => 'text-danger',
																		'data-pjax'             => 0,
																		'data-title-confirm'    => Yii::t('app', 'Eliminar registro'),
																		'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea eliminar registro?'),
																		'data-runtime'          => 'ajax-confirm',
																		'data-label-btn-cancel' => Yii::t('yii', 'No'),
																		'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
																		'data-icon-class'       => 'fa fa-trash',
																		//'data-pjax-target'      => '#' . $this->context->pjaxId,
																	]);
																},
															]
														],
													],
												]);
											?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="inactivas" class="tab-pane fade">
						<div id="grid-inactives" class="container-fluid">
							<div class="row" >
								<div class="col-sx-12">
									<div class="padding-h-15">
										<div class="padding-top-5">
											<div class="table-responsive">
												<?php
													echo GridView::widget([
														'filterModel'   => $this->context->model,
														'dataProvider'  => $data->inactives,
														'tableOptions'  => ['class' => 'table' ],
														'layout'        => '<div>{items}</div><div class="text-center">{pager}</div>',
														'columns'       => [
															[
															    'class'    => 'yii\grid\ActionColumn',
															    'header'   => Yii::t('app', 'Habilitar'),
															    'visible'  => true,
															    'template' => '{btn}',
															    'contentOptions' => ['style' => 'width: 70px', 'class' => 'text-center'],
															    'buttons' => [
															        'btn' => function($url, $model, $key){

																		switch (true)
																		{
																			case ($this->context->action->perfil ==  UserIdentity::PROFILE_ADMIN_SUCURSAL):
																				$prefixRoute = $this->context->currentController . '/administradores';
																				break;

																			case ($this->context->action->perfil ==  UserIdentity::PROFILE_DOCENTE):
																				$prefixRoute = $this->context->currentController . '/docentes';
																				break;
																		}


															            $link = Url::toRoute([$prefixRoute .'-toggle-status', 'id' => $key ]);
															            $text = Fa::icon('check')->fw();
															            return Html::a($text, $link, [
															                'title'                 => Yii::t('app', 'Habilitar registro') ,
															                'class'                 => 'text-success',
															                'data-pjax'             => 0,
															                'data-title-confirm'    => Yii::t('app', 'Habilitar registro'),
															                'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea habilitar este registro?'),
															                'data-runtime'          => 'ajax-confirm',
															                'data-label-btn-cancel' => Yii::t('yii', 'No'),
															                'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
															                'data-icon-class'       => 'fa fa-check',
															                'data-pjax-target'      => '#' . Yii::$app->controller->pjaxId,
															            ]);
															        },
															    ],
															],

															[
																'header' => 'Imagen',
																'format' => 'raw',
																'contentOptions' => ['style' => 'width: 50px', 'class' => 'text-center'],
																'value' => function($model){
																	return Html::img( $model->getAvatar(),[
																		'style' => 'width:28px;margin:0 auto; display:block;'
																	]);
																}
															],
															[
																'attribute' => 'nro_documento',
																'value' => function($model){
																	return $model->getDNI();
																}
															],
															'nombres',
															'apellidos',
															'email',
															[
																'class'             => 'yii\grid\ActionColumn',
																'header'            => Yii::t('app', 'Acciones'),
																'contentOptions'    => ['style' => 'width: 100px', 'class' => 'text-center'],
																'template'          => '{update} {delete}',
																'buttons'   => [
																	'update' => function ($url, $model, $key){

																		switch (true)
																		{
																			case ($this->context->action->perfil ==  UserIdentity::PROFILE_ADMIN_SUCURSAL):
																				$prefixRoute = $this->context->currentController . '/administradores';
																				break;

																			case ($this->context->action->perfil ==  UserIdentity::PROFILE_DOCENTE):
																				$prefixRoute = $this->context->currentController . '/docentes';
																				break;
																		}

																		$link = Url::toRoute([$prefixRoute . '-update' , 'id' => $key , 'idSucursal'=>  $this->context->action->modelSucursal->id ]);

																		return Html::a(Fa::icon('edit')->fw() , $link, [
																			'title'      =>  Yii::t('app', 'Actualizar registro') ,
																			'class'      => 'text-info',
																			'data-pjax'  => 0,
																			'data-role' => 'open-modal',
																		]);
																	},

																	'delete' => function ($url, $model, $key){

																		if($model->id_perfil == $model::PROFILE_ADMIN_SUCURSAL)
																			$link = Url::toRoute([$this->context->currentModule . '/personal-administrativo/admin-delete' , 'id' => $key , 'redirect' => $this->context->currentUrl]);
																		else
																			$link = Url::toRoute([$this->context->currentModule . '/personal-administrativo/doc-delete' , 'id' => $key , 'redirect' => $this->context->currentUrl]);

																		return Html::a( Fa::icon('trash')->fw() , $link, [
																			'title'                 => Yii::t('app', 'Eliminar registro') ,
																			'class'                 => 'text-danger',
																			'data-pjax'             => 0,
																			'data-title-confirm'    => Yii::t('app', 'Eliminar registro'),
																			'data-text-confirm'     => Yii::t('app', '¿Esta seguro que desea eliminar registro?'),
																			'data-runtime'          => 'ajax-confirm',
																			'data-label-btn-cancel' => Yii::t('yii', 'No'),
																			'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
																			'data-icon-class'       => 'fa fa-trash',
																			//'data-pjax-target'      => '#' . $this->context->pjaxId,
																		]);
																	},
																]
															],
														],
													]);
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php Pjax::end(); ?>
