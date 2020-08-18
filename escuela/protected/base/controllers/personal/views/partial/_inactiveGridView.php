<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\helpers\Url;
	use base\widgets\faicons\Fa;
	use yii\widgets\Pjax;

	Pjax::begin([
		'id'                => $this->context->pjaxId,
		'enablePushState'   => false,
	]);
?>
<div class="row" id="<?= $this->context->pjaxId; ?>">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<?php echo Fa::icon($this->iconClass)->fw(); ?>
					<?php echo $this->H1;?>
				</h3>
			</div>
			<div class="panel-body" >
				<div class="padding-v-15" >
					<div class="container-fluid">
						<div class="row">
							<div style="margin:0 15px">
								<div class="col-sx-12 text-right">
									<?php
										if($this->context->action->filterProfile == Yii::$app->user->identity::PROFILE_ADMIN_SUCURSAL)
											$route = Url::toRoute([ $this->context->currentController .'/admin-create']);
										else
											$route = Url::toRoute([ $this->context->currentController .'/doc-create']);

										echo Html::a(Yii::t('app', 'Nuevo registro'), $route, [
											'class'     => 'btn btn-primary',
											'data-pjax' => 0
										]);
									?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="padding-v-15" >
					<div class="container-fluid">
						<div class="row" >
						<div class="col-sx-12">
							<div class="padding-h-15">
								<div class="padding-top-5">
									<div class="table-responsive">
										<?php
											echo GridView::widget([
												'filterModel'	=> $this->context->model,
												'dataProvider'  => $this->context->dataProvider,
												'tableOptions'  => ['class' => 'table' ],
												'layout'        => '<div>{items}</div><div class="text-center">{pager}</div>',
												'columns'		=> [
													Yii::$app->tools::configColumnActivate([
														'visible' => Yii::$app->user->identity->isAdmin(),
													]),
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

																if($model->id_perfil == $model::PROFILE_ADMIN_SUCURSAL)
																	$link = Url::toRoute([$this->context->currentModule . '/personal-administrativo/admin-update' , 'id' => $key ]);
																else
																	$link = Url::toRoute([$this->context->currentModule . '/personal-administrativo/doc-update' , 'id' => $key ]);

																return Html::a(Fa::icon('edit')->fw() , $link, [
																	'title'      =>  Yii::t('app', 'Actualizar registro') ,
																	'class'      => 'text-info',
																	'data-pjax'  => 0,
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

<?php Pjax::end(); ?>
