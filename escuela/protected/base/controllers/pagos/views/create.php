 <?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\Json;
    use yii\helpers\ArrayHelper;
    use base\widgets\faicons\Fa;
    use yii\bootstrap\ActiveForm;
    use kartik\date\DatePicker;

	$this->registerJs('
		(function(){
			modal.reset.default();
			modal.content.addClass("fade in");
			modal.icon.attr("class", "fa fa-'. $this->iconClass .' fa-fw");
			modal.title.html(" '. $this->H1 .'");
			modal.header.show();
			modal.header.btnClose.show();
			modal.body.show();
			modal.content.show();
			modal.footer.hide();
		})();
	', $this::POS_END);

?>

Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
<div>
	<code><?= __FILE__ ?></code>
</div>
