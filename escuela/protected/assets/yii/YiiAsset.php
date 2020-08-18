<?php

namespace app\assets\yii;
use Yii;
use yii\web\AssetBundle;

class YiiAsset extends AssetBundle
{
	public $basePath        = '@webroot';
	public $sourcePath      = __DIR__ . '/dist';
	public $css             = [];
	public $js              = [];
	public $depends         = [];
	public $publishOptions  = [];

	public function init()
	{
		$this->jsOptions['position'] = Yii::$app->View::POS_HEAD;
		parent::init();
		if(Yii::$app->request->isAjax)
			return;

		$this->js = [
			'js/yii.min.js',
		];
	}
}


