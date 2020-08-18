<?php

namespace app\assets\dashboard;
use Yii;
use yii\web\AssetBundle;

class DashoardAsset extends AssetBundle
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
			'js/pace.js',
			'js/dashborard-functions.js',
			'js/wickedpicker.min.js',
			'js/runtime.min.js',
		];

		$this->css = [
			'css/dashboard.min.css',
			'css/wickedpicker.min.css',
			'css/overload.css',
		];

		$this->depends = [
			'app\assets\yii\YiiAsset',
		];
	}
}


