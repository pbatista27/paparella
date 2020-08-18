<?php
    use base\widgets\faicons\Fa;
    use yii\helpers\Url;
    use yii\helpers\Html;
    $itemDelete = uniqid('item_');
    $itemUpdate = uniqid('item_');
?>

<div class="col-md-6">
	<div style="border:1px solid #cecece; border-radius:6px; margin-bottom:30px">
		<div class="header" style="padding-bottom:15px; border-bottom:1px solid #cecece; padding:20px 15px 10px">
			<div class="clearfix">
				<div class="pull-left">
					<h4><?= Html::encode($model->titulo); ?></h4>
				</div>
				<div class="pull-right">
					<small>
					<?php
						echo $label = Yii::t('app', '{n,plural,=0{Sin días programados} =1{ 1 día programado} other{# día programados}}', ['n' => $model->nro_dias ]);
					?>
					</small>
				</div>
			</div>
		</div>

		<div class="body" style="height:120px; padding: 15px;padding-right: 15px;  overflow-y: scroll;">
			<p class="text-justify">
				<?= Html::encode($model->descripcion); ?>
			</p>
		</div>

		<div class="footer" style="padding-bottom:15px; border-top:1px solid #cecece; padding:20px 15px 10px">
			<div class="text-right">
            <?php
            	if($widget->dataProvider->getTotalCount() > 1 || $this->context->model->is_tmp)
				{
					echo Html::a(Fa::icon('times'), Url::toRoute([$route . '/delete', 'id' => $model->id , 'idCurso' => $model->id_curso ]),
					[
						'id'					=> $itemDelete,
						'class'					=> 'btn btn-primary',
						'data-pjax' 			=> 0,
						'class'					=> 'btn btn-danger',
						'data-runtime' 			=> 'ajax-confirm',
	                    'data-title-confirm'    => Yii::t('app', 'Eliminar {programa}', ['programa' => $model->titulo ]),
	                    'data-text-confirm'     => Yii::t('yii', 'Are you sure you want to delete this item?'),
	                    'data-runtime'          => 'ajax-confirm',
	                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
	                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
	                    'data-icon-class'       => 'fa fa-trash',
	                    'data-pjax-target'		=> '#' . $this->context->pjaxId,
					]);
            	}
			?>
			<?php
				echo Html::a(Fa::icon('edit'), Url::toRoute([$route . '/update', 'id' => $model->id, 'idCurso' => $model->id_curso, 'pjaxId' => $this->context->pjaxId ]),
				[
					'id'		=> $itemUpdate,
					'class'		=> 'btn btn-primary',
					'data-pjax' => 0,
					'data-role' =>'open-modal',
					'class'		=> 'btn btn-info',
				]);
			?>
			</div>
		</div>
	</div>
</div>
