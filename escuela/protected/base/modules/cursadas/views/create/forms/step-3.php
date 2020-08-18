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
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<hr>
			<h4 class="text-center"> Evaluacion</h4>
			<p>El curso consta de <?= $this->context->session['step-1']['cantidad_meses']   ?> Meses</p>
			<p>El curso consta de <?= $this->context->session['step-1']['cantidad_clases']  ?> Días de clases</p>
			<hr>
		</div>
		<div class="col-md-3"></div>
	</div>

	<div class="row">
		<div class="col-md-3"></div>
		<?php
			echo $form->field($this->context->model, 'examen', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->dropDownList( $this->context->model->getMapExamen($this->context->session['step-1']['id_curso_sucursal']) ,[
				'prompt'=> '--',
			]);
		?>
		<div class="col-md-3"></div>
	</div>

	<div class="row margin-top-15">
		<div class="col-md-3"></div>
		<?php
			echo $form->field($this->context->model, 'dia_inicio_evaluacion', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-3']])->textInput(['type' => 'number', 'placeholder'=>$this->context->model->getAttributeLabel('dia_inicio_evaluacion')]);
			echo $form->field($this->context->model, 'dia_fin_evaluacion',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-3']])->textInput(['type' => 'number', 'placeholder'=>$this->context->model->getAttributeLabel('dia_fin_evaluacion')]);

		?>
		<div class="col-md-3"></div>
	</div>

	<div class="row margin-top-30">
		<div class="col-md-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-6 text-right">
			<?php echo Html::submitButton(Yii::t('app','Finalizar'), ['class' => 'btn btn-primary', 'data-pjax' => 0 ]);?>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>
<?php $form::end() ?>
