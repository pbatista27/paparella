<?php
namespace base;
use Yii;
use yii\helpers\Url;

class View extends \yii\web\View
{
	public 	$H1;
	public 	$viewHint;
	public 	$breadcrumbs = [];
	public  $menu;
	public  $suffixDOM;
	public  $iconClass;

	public function init()
	{
		parent::init();
		$this->suffixDOM = uniqid('_item');
	}
}
