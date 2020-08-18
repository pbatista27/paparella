<?php
    use base\widgets\faicons\Fa;
    use yii\helpers\Url;
    use yii\helpers\Html;
    $itemDelete = uniqid('item_');
    $itemUpdate = uniqid('item_');

    switch ($model->id_tipo_contenido)
    {
		case 1:
			$prefixRoute = '/' . $this->context->module->id . '/material-programa';
			break;

		case 2:
			$prefixRoute = '/' . $this->context->module->id . '/material-docentes';
			break;

		case 3:
			$prefixRoute = '/' . $this->context->module->id . '/material-estudiantes';
			break;

		case 4:
			$prefixRoute = '/' . $this->context->module->id . '/examenes';
			break;
    }

?>

<div class="col-md-3">
	<div style="border:1px solid #cecece; border-radius:6px; margin-bottom:30px">
		<div class="header text-center" style="padding-bottom:15px; border-bottom:1px solid #cecece; padding:20px 15px 10px">
			<h5><?= Html::encode($model->nombre) ?></h5>
		</div>

		<div class="body text-center" style="height:100px; padding: 15px;" >
			<?php
				echo Html::a(Fa::icon('download')->size('5x') , Url::toRoute(['/' . $this->context->module->id .  '/download/index', 'id' => $model->id]), [
					'target' => '_blank',
					'data-pjax' => 0,
				]);
			?>
		</div>

		<div class="fotter" style="padding-bottom:15px; border-top:1px solid #cecece; padding:20px 15px 10px">
			<div class="text-right">
            <?php
            	if($widget->dataProvider->getTotalCount() > 1 || $this->context->model->is_tmp)
				{
					echo Html::a(Fa::icon('times'), Url::toRoute(['/'. $prefixRoute .'/delete' , 'id' =>$model->id, 'idCurso' => $model->id_curso ]),
					[
						'id'			=> $itemDelete,
						'class'			=> 'btn btn-primary',
						'data-pjax' 	=> false,
						'class'			=> 'btn btn-danger',
						'data-runtime' 	=> 'ajax-confirm',
	                    'data-title-confirm'    => Yii::t('app', 'Eliminar {material}', ['material' => $model->nombre ]),
	                    'data-text-confirm'     => Yii::t('yii', 'Are you sure you want to delete this item?'),
	                    'data-runtime'          => 'ajax-confirm',
	                    'data-label-btn-cancel' => Yii::t('yii', 'No'),
	                    'data-label-btn-ok'     => Yii::t('yii', 'Yes'),
	                    'data-icon-class'       => 'fa fa-trash',
	                    'data-pjax-target'   	=> '#' . $this->context->pjaxId,
					]);
            	}
			?>

			<?php
				echo Html::a(Fa::icon('edit'), Url::toRoute(['/'.$prefixRoute.'/update', 'id' =>$model->id, 'idCurso' => $model->id_curso , 'pjaxId' => $this->context->pjaxId ]),
				[
					'id'		=> $itemUpdate,
					'class'		=> 'btn btn-primary',
					'data-pjax' => false,
					'data-role' =>'open-modal',
					'class'		=> 'btn btn-info',
				]);
			?>
			</div>
		</div>
	</div>
</div>
