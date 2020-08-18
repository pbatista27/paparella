<?php
namespace controllers\configuracion;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\HttpException;

use controllers\TraitControllers;
use controllers\configuracion\models\RedesSociales;
use controllers\configuracion\models\VideoPromocional;

class Controller extends \base\Controller
{
    use TraitControllers;

	public function beforeAction($action)
	{
        if(parent::beforeAction($action) == false)
            return false;

        if(!Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        return true;
	}

	public function actionRedesSociales()
    {
	    if(!Yii::$app->request->isAjax)
	        throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        $this->view->H1 = Yii::t('app','Redes sociales');
        $this->view->iconClass = "link";
        $this->model = RedesSociales::findOne(1);
        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha modificado los datos de redes sociales de la aplicación!</h5>') );

        return $this->renderAjax('redes-sociales');
    }

	public function actionVideoPromocional()
    {
        if(!Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        $this->view->H1 = Yii::t('app','Video promocional');
        $this->view->iconClass = "youtube";
        $this->model = VideoPromocional::findOne(1);

        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha modificado su video promocional de la aplicación!</h5>') );

        return $this->renderAjax('video-promocional');
    }
}


