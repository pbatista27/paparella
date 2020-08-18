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
		</div>
	</div>

	<div class="row">
		<?php
			echo $form->field($this->context->model, 'id_curso_sucursal',  	[ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->dropDownList( $this->context->model->getMapActiveCS($this->context->model->sucursal) ,[
				'prompt'=> '--',
			]);
			echo $form->field($this->context->model, 'fecha_inicio', [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('fecha_nacimiento')])->widget(DatePicker::classname(), [
				'options' => ['placeholder' => $this->context->model->getAttributeLabel('fecha_inicio'), 'autocomplete' => 'off' ],
				'language'=>'es',
				'pluginOptions' => [
					'autoclose'=>true,
					'format'=>'yyyy-mm-dd',
		  		],
			]);
		?>
	</div>

	<div class="row">
		<?php
			echo $form->field($this->context->model, 'periodo',   	 [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('periodo')]);
			echo $form->field($this->context->model, 'seccion',   	 [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-3']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('seccion')]);
			echo $form->field($this->context->model, 'nro_cupos',    [ 'inputOptions' => ['autocomplete' => 'off'] , 'options' => ['class' => 'col-xs-12 col-sm-12 col-md-3']])->textInput(['placeholder'=>$this->context->model->getAttributeLabel('nro_cupos')]);
		?>
	</div>


	<div class="row margin-top-30">
		<div class="col-xs-12 col-sm-12 col-md-12 text-right">
			<?php echo Html::submitButton(Yii::t('app','Siguiente') . ' '. Fa::Icon('arrow-right')->fw() , ['class' => 'btn btn-primary', 'data-pjax' => 0 ]); ?>
		</div>
	</div>
</div>
<?php $form::end() ?>
