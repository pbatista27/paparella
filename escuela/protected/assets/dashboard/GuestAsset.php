<?php

namespace app\assets\dashboard;
use Yii;
use yii\web\AssetBundle;

class GuestAsset extends AssetBundle
{
	public $basePath        = '@webroot';
	public $sourcePath      = __DIR__ . '/dist';
	public $css             = [];
	public $js              = [];
	public $depends         = [];
	public $publishOptions  = [];

	public function init()
	{
		parent::init();
		if(Yii::$app->request->isAjax)
			return;

		$this->js = [
			'js/dashboard.min.js',
			'js/dashborard-functions.js',
			'js/runtime.min.js',
      		'js/guest.js',
		];

		$this->css = [
			'css/dashboard.min.css',
			'css/overload.css',
      		'css/guest.css'
		];

		$this->depends = [
			'app\assets\yii\YiiAsset',
		];
	}
}
