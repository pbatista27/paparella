 <?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\Json;
    use yii\helpers\ArrayHelper;
    use base\widgets\faicons\Fa;
    use yii\bootstrap\ActiveForm;
    use yii\widgets\Pjax;
    use yii\grid\GridView;

    $this->registerJs('
		modal.reset.default();
		modal.size("modal-50");
		modal.content.addClass("fade in");
		modal.icon.attr("class", "fa fa-'. $this->iconClass .' fa-fw");
		modal.title.html("'. $this->H1 .'");
		modal.header.show();
		modal.header.btnClose.show();
		modal.body.show();
		modal.content.show();
		modal.footer.hide();


		function deleteUserCursada(element){

			var item = $(element).data("item");
			modal.addLoader();
			$.ajax({
				url  : "'.  Url::toRoute([$this->context->currentController . '/'. $this->context->currentAction , 'idCursada' => Yii::$app->request->get('idCursada') ]) .'",
				data : {index : item},
				type : "POST",
			})
			.always(function(){
				modal.rmLoader();
			})
			.done(function(){
				$("#grid").yiiGridView("applyFilter");

				setTimeout(function(){
					try{
						$.pjax.reload({container: "cursadas"});
					}
					catch(e){
						console.log(e);
					}
				}, 750);
			});
		}



    ', $this::POS_END);

	Pjax::begin([
		'id' 				=> 'pjax-grid-view',
		'enablePushState' 	=> false,
		'timeout' 			=> 0,
	]);
?>
<div class="container-fluid margin-v-15" >
	<div class="row margin-v-15">
		<div class="row" style="margin:0 30px; padding-bottom:30px; border-bottom:2px solid #ddd">
			<div >
				<?php
					$form = ActiveForm::begin([
						'id'                    => 'grid-filters',
						'enableClientScript'    => true,
						'method'				=> 'get',
						'options'				=> ['data-pjax' => 1]
					]);
				?>
				<input type="search"  value="<?=  Yii::$app->request->getQueryParam('search', null) ?>" name="search" class="form-control"  placeholder="<?= Yii::t('app', 'Filtrar resultados') ?>" autocomplete="off">
				<button type="submit" class="btn btn-info pull-right" style="margin-top:-34px; border-radius: 0 6px 6px 0;">
					<?= Yii::t('app', 'Filtrar resultados') ?>
				</button>
				<?php $form::end(); ?>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
		        <?php
		            echo GridView::widget([
		            	'id'			=> 'grid',
		                'dataProvider'  => $this->context->dataProvider,
		                'layout'        => '<div>{items}</div><hr><div class="text-center margin-top-30">{pager}</div>',
		                'tableOptions'  => ['class' => 'table' ],
		                'columns' => [
		                    [
		                        'header'         => Yii::t('app', 'Agregar'),
		                        'class'          => 'yii\grid\ActionColumn',
		                        'template'       => '{btn}',
		                        'contentOptions' => ['style' => 'width: 50px', 'class' => 'text-center'],
		                        'buttons' => [
		                            'btn' => function ($url, $model, $key){
		                                $text = Fa::icon('times')->fw();
		                                $link = 'javascript:void(0)';

		                               	return Html::a($text, $link, [
		                               		'data-item'	   => $key,
		                               		'onclick'      =>'deleteUserCursada(this)',
		                               		'class'		   => 'text-danger'
		                               	]);
		                            }
		                        ],
		                    ],
		                    [
		                        'header' => 'Imagen',
		                        'format' => 'raw',
		                        'contentOptions' => ['style' => 'width: 70px', 'class' => 'text-center'],
		                        'value' => function($model){
		                            return Html::img( $model->getAvatar(),[
		                                'style' => 'width:28px;margin:0 auto; display:block'
		                            ]);
		                        }
		                    ],
		                    [
		                        'attribute' => 'nombres',
		                        'contentOptions' => ['style' => 'width: 50%'],
		                        'value'     => function($model){
		                            return $model->getUsername(false);
		                        }
		                    ],
		                    [
		                        'attribute' => 'nro_documento',
		                        'contentOptions' => ['style' => 'width: 50%'],
		                        'value' => function($model){
		                            return $model->getDNI();
		                        }
		                    ],
		                ],
		            ]);
		        ?>
				</div>
			</div>
    	</div>
    </div>
</div>

<?php Pjax::end() ?>
