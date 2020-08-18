<?php
namespace base\widgets\faicons;

use Yii;
use yii\web\AssetBundle;

class FaAsset extends AssetBundle
{
	public $basePath   = '@webroot';
	public $sourcePath = '@app/widgets/fontawesome4/assets';

	public function init()
	{
		parent::init();

		if(Yii::$app->request->isAjax)
			return;

		$this->css = [
			'css/font-awesome.min.css',
		];
	}
}

