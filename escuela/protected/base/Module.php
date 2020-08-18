<?php
namespace base;
use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

abstract class Module extends \yii\base\Module
{
	public function init()
	{
		parent::init();
		Yii::setAlias('@moduleLayouts', $this->getBasePath() .'/views/layouts' );

		if(Yii::$app->user->isGuest && Yii::$app->request->isAjax == 0)
			exit(header('location:' . Url::toRoute(Yii::$app->user->loginUrl) ));

		if($this->checkAccessByProfile() != true)
			throw new ForbiddenHttpException(Yii::t('app', 'Sin permisos para visualizar este contenido.'));
	}

	abstract protected function checkAccessByProfile();
}
