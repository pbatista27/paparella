<?php
namespace base\widgets\dashboard;

use Yii;
use yii\helpers\Html;

use yii\base\InvalidConfigException;
use base\widgets\faicons\Fa;

class BoxNotification extends \yii\bootstrap\Widget
{
	public $icon;
	public $link = '#';
	public $headTitle;
	public $footerTitle;
	public $count;
	public $visibility;

	public function init()
	{
		parent::init();
		$this->icon  	   = ($this->icon)        ?: Fa::icon('star')->fw();
		$this->headTitle   = ($this->headTitle)   ?: Yii::t('app','Title Notification');
		$this->footerTitle = ($this->footerTitle) ?: Yii::t('app','Ver detalles..');

		if(!is_array($this->link))
			$this->link = [$this->link, []];

		else
			$this->link = [
				(isset($this->link[0])) ? $this->link[0] : '#',
				(isset($this->link[1])) ? $this->link[1] : [],
			];
	}

	public function run()
	{
		if($this->visibility !== true)
			return;

		return $this->render('box-notification',[
			'href' 			=> $this->link[0],
			'urlOptions' 	=> $this->link[1],
		]);
	}
}


