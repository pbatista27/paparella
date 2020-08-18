<?php
namespace base\modules\admin\cursos;

use yii;

class Module extends \base\Module
{
    public $controllerNamespace = 'base\modules\admin\cursos\controllers';

    protected function checkAccessByProfile()
    {
    	if(Yii::$app->user->isGuest)
    		return false;

    	return Yii::$app->user->identity->isAdmin();
    }
}
