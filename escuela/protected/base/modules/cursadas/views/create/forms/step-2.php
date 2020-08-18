<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\Json;
	use base\widgets\faicons\Fa;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\ArrayHelper;
	use kartik\checkbox\CheckboxX;
	use kartik\date\DatePicker;

	$form = ActiveForm::begin([
		'id' => 'form' . $this->suffixDOM,
	]);
?>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<hr>
			<h4 class="text-center">
				<?php echo  Yii::t('app', 'Favor selccionar los días de clases semanales') ?>
			</h4>
			<hr>
		</div>
	</div>
	<?php
		for($i = 1 ; $i< 8 ; $i++):
			$aulaAttr  = 'd'.$i.'_aula';
			$desdeAttr = 'd'.$i.'_desde';
			$hastaAttr = 'd'.$i.'_hasta';
			$diaLabel  = Yii::t('app', 'Horas de clases para los días {0}', [ $this->context->model->getAttributeLabel('dia'. $i) ]);

			$newRow = $i % 2 == 1 ? true : false;
			if($newRow) echo '<div class="row">';
	?>

	<div class="col-md-6">
		<label style="margin:0"><?= $diaLabel; ?></label>
		<div class="container-fluid" style="margin:0; padding:0">
			<div class="row">
				<div class="col-md-4">
					<?php
						echo $form->field($this->context->model, $desdeAttr , ['inputOptions' => ['autocomplete' => 'off']])->textInput([
							'class'=>'form-control',
							'placeholder'  => $this->context->model->getAttributeLabel($desdeAttr),
							'data-runtime' => 'wickedpicker',
							'data-title'   =>  $this->context->model->getAttributeLabel('dia'. $i) . ' - ' . $this->context->model->getAttributeLabel($desdeAttr),
							'data-init'    => '07:00',
						])
						->label(false);
					?>
				</div>
				<div class="col-md-4">
					<?php
						echo $form->field($this->context->model, $hastaAttr , ['inputOptions' => ['autocomplete' => 'off']])->textInput([
							'class'			=> 'form-control',
							'placeholder'  	=> $this->context->model->getAttributeLabel($hastaAttr),
							'data-runtime' 	=> 'wickedpicker',
							'data-title'   	=> $this->context->model->getAttributeLabel('dia'. $i) . ' - ' . $this->context->model->getAttributeLabel($hastaAttr),
							'data-init'    => '07:45',
						])
						->label(false);
					?>
				</div>
				<div class="col-md-4">
					<?php
						echo $form->field($this->context->model, $aulaAttr , ['inputOptions' => ['autocomplete' => 'off']])->textInput(['placeholder'=> $this->context->model->getAttributeLabel($aulaAttr) ])
						->label(false);
					?>
				</div>
				<div class="col-md-12">
					<hr style="margin-top:7px; margin-bottom:15px">
				</div>
			</div>
		</div>
	</div>

	<?php if($i == 7):?>
		<?php
			echo $form->field($this->context->model, 'fechas_excluidas', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('fechas_excluidas')])->widget(DatePicker::classname(), [
				'options' => ['placeholder' => $this->context->model->getAttributeLabel('fechas_excluidas'), 'autocomplete' => 'off' ],
				'language'=>'es',
				'pluginOptions' => [
					'type'   			 => DatePicker::TYPE_COMPONENT_APPEND,
						'format' 			 => 'yyyy-mm-dd',
						'multidate' 		 => true,
						'multidateSeparator' => ',',
					'clearBtn' 			 => true,
					'todayHighlight' 	 => true,
	  			],
			])->label($this->context->model->getAttributeLabel('fechas_excluidas'), [ 'style' => 'margin-bottom:15px'] );
		?>
		<div class="col-md-6">
			<hr style="margin-top:22px;margin-bottom:15px">
		</div>
	<?php endif; ?>

	<?php
		if($newRow == false) echo '</div>';
		endfor;
	?>
	<div class="col-md-12">
		<div class="row margin-v-15">
			<div class="col-xs-12 col-sm-12 col-md-12 text-right">
				<?php
					$urlBack = Url::toRoute([$this->context->currentController . '/index', 'step' => ($this->context->step-1) , 'idSucursal' => Yii::$app->request->get('idSucursal', 0)  ]);
					echo Html::a(  Fa::Icon('arrow-left')->fw() . ' ' . Yii::t('app','Anterior')  , $urlBack , $options = ['class' => 'btn btn-primary', 'style' => 'margin-right:10px', 'data-pjax' => 0 ]);
					echo Html::submitButton(Yii::t('app','Siguiente')  . ' ' . Fa::Icon('arrow-right')->fw()  , ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);
				?>
			</div>
		</div>
	</div>
</div>
<?php
	$form::end();
	$this->registerJs('registerWickedpicker();', $this::POS_END);
	return;
?>
