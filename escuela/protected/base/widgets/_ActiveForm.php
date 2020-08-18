<?php
namespace base\widgets;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;


class ActiveForm extends \yii\bootstrap\ActiveForm
{
	public $options = [
		'class' => 'form-horizontal',
	];

	public $enableAjaxValidation = true;
	public $enableClientScript	 = true;
	public $validateOnChange	 = true;
	public $validateOnSubmit	 = true;
	public $validateOnBlur		 = true;
	public $ajaxParam			 = 'ajax';
	public $js                   = null;
	public $registerDefaultJs    = true;
	// ChildClassAttributes:
	public $resetOnSuccess		 = false;
	public $nodeLoader;

	//@todo add list pjax actions son success form
	public $pjaxUpdate = null;

	public function init()
	{
		$this->resetOnSuccess = ($this->resetOnSuccess === true)?:false;
		$this->id = empty($this->id) ? uniqid('form_') : $this->id;

		if(empty($this->nodeLoader))
			$this->nodeLoader =  Yii::$app->request->isAjax ?  'modal.content' : '#' .  $this->id;

		parent::init();
	}

	public function registerClientScript()
	{
		parent::registerClientScript();
		if($this->registerDefaultJs == false)
			return;

		$view = $this->getView();

		$config = [
			'el' 		 	 		=> '#' . $this->id,
			'resetOnSuccess' 		=> ($this->resetOnSuccess === true)?:false,
			'nodeLoader'     		=> $this->nodeLoader,
			'pjaxUpdate'            => ($this->pjaxUpdate) ? $this->pjaxUpdate : false,
		];

		$js = '(function(){

			var config      = '.  Json::encode($config) .';
			var	form        = $(config.el);
			form.nodeLoader = config.nodeLoader == "modal.content" ? modal.content : $(config.nodeLoader);
			form.hasError   = function(){return form.find(".has-error").length;};
			hasAjaxRequest  = config.nodeLoader == "modal.content" ? true: false;
			var countAjax   = 0;

			function messageSuccess(title,msn){
				modal.reset.default();
				modal.icon.attr("class", "fa fa-check text-success");
				modal.title.html(title);
				modal.header.show();
				modal.size("modal-confirm");

				// add element button
				var btnClose = $("<button>").attr({
					"type"         : "button",
					"class"        : "btn btn-info",
					"data-dismiss" : "modal",
				}).text("' . Yii::t('app', 'Aceptar') .'");

				// insert into footer modal
				modal.footer.html(btnClose).show();
				modal.body.addClass("text-center").html("<div class=\"text-center padding-v-15\">" +msn + "</div>").show();
				modal.open();

				if(config.pjaxUpdate)
					$.pjax.reload({ container: config.pjaxUpdate });
				else{
					modal.bsModal.on("hidden.bs.modal", function(){
						window.location.reload(true)
					});
				}
			}

			function submit(){
				countAjax++;
				$(":input").blur();
				form.nodeLoader.addLoader();
				$.ajax({
					url  : form.attr("action"),
					type : form.attr("method"),
					data : form.serialize(),
					data : form.serialize(),
				})
				.done(function(data){
					var status = data.status || false;

					if(data.status != true){
						return form.yiiActiveForm("validate", true); //aqui esta el problema
						countAjax++;
					}

					if(config.resetOnSuccess == true)
						form.get(0).reset();

					messageSuccess(data.statusCode , data.statusText);
				})
				.always( function(){
					form.nodeLoader.rmLoader();
				})
				.fail(function(data){
					// @todo add functions..
					console.log(data);
				});
			}

			// events
			form.on("beforeSubmit", function(e){
				e.preventDefault();
				e.stopPropagation();

				if(form.hasError() != true && countAjax < 1)
					submit();
				else
					countAjax=0;

				return false;
			});

		})();';

		$this->js = (empty($this->js)) ? $js : $this->js;

		$view = $this->getView();
		$view->registerJs( $this->js , $view::POS_END);
	}
}
