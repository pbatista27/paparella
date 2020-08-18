<?php
	use yii\helpers\Html;
	use yii\helpers\StringHelper;
	use base\widgets\faicons\Fa;


	$urlAttributes = null;

	foreach($urlOptions as $key => $value)
		$urlAttributes.= ' ' . $key .'="'.$value.'"';
?>
<div class="col-md-3" id="<?php echo $this->context->id; ?>" style="margin-bottom:15px">
	<a href="<?php echo $href; ?>" <?php echo $urlAttributes?> >
		<div class="tile tile-primary">
			<div class="tile-heading text-center font-12">
				<?php echo $this->context->headTitle; ?>
			</div>
			<div class="tile-body clearfix">
				<div class="pull-left">
					<?php echo $this->context->icon; ?>
				</div>
				<div class="pull-right">
					<h2 class="margin-0 font-25 line-h-58">
						<?php
							switch (true)
							{
								case (is_object($this->context->count)):

									if($this->context->count->active === $this->context->count->total)
										echo $this->context->count->active;
									else
										echo $this->context->count->active . ' / '. $this->context->count->total;
									break;

								case (is_string($this->context->count) || is_numeric($this->context->count)):
									echo $this->context->count;
									break;

								case (empty($this->context->count)):
									echo 0;
									break;
							}
						?>
					</h2>
				</div>
			</div>

			<div class="tile-footer text-center text-upper font-12">
				<span><?php echo $this->context->footerTitle; ?></span>
				<span class="pull-right"><?php echo Fa::icon('chevron-right')->fw(); ?></span>
			</div>
		</div>
	</a>
</div>




