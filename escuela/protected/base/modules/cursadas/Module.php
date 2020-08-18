<?php
namespace base\modules\cursadas;

use yii;

class Module extends \base\Module
{
    public $controllerNamespace = 'base\modules\cursadas\controllers';

    protected function checkAccessByProfile()
    {
    	if(Yii::$app->user->isGuest)
    		return false;

    	return true;
    }
}
