<?php
namespace controllers\account;

use Yii;
use yii\web\HttpException;
use yii\helpers\Url;

use controllers\TraitControllers;
use controllers\account\models\DatosBasicos;
use controllers\account\models\DatosContacto;
use controllers\account\models\PersonaContacto;
use controllers\account\models\RedesSociales;
use controllers\account\models\Password;

class Controller extends \base\Controller
{
    use TraitControllers;

    public function beforeAction($action)
    {
    	$this->defaultRouteUrl = Url::toRoute(['/account/index']);
        if(parent::beforeAction($action) == false)
            return false;

        if($action->id == 'cambiar-password')
            return true;

        if(!Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        return true;
    }

    public function actionIndex()
    {
        $this->view->H1        = Yii::t('app', 'Mi cuenta');
        $this->view->iconClass = 'user';
        return $this->renderAjax('index');
    }

    public function actionDatosBasicos()
    {
        $this->view->H1         = Yii::t('app', 'Mi cuenta - datos basicos');
        $this->view->iconClass  = 'user';
        $this->model            = DatosBasicos::find()->where('id=:id', [':id' =>  Yii::$app->user->identity->id ])->one();

        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha actualizado sus datos basicos</h5>') );

        return $this->renderAjax('datos-basicos');
    }

    public function actionDatosContacto()
    {
        $this->view->H1         = Yii::t('app', 'Mi cuenta - datos de contacto');
        $this->view->iconClass  = 'user';
        $this->model            = DatosContacto::find()->where('id=:id', [':id' =>  Yii::$app->user->identity->id ])->one();

        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha actualizado sus datos de contacto</h5>') );

        return $this->renderAjax('datos-contacto');
    }

    public function actionPersonaContacto()
    {
        $this->view->H1         = Yii::t('app', 'Mi cuenta - persona de contacto');
        $this->view->iconClass  = 'user';
        $this->model            = PersonaContacto::find()->where('id=:id', [':id' =>  Yii::$app->user->identity->id ])->one();

        if(is_null($this->model))
        {
            $this->model        = new PersonaContacto();
            $this->model->id    = Yii::$app->user->identity->id;
            $this->model->save(false);
        }

        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha actualizado sus datos de persona de contacto</h5>') );

        return $this->renderAjax('persona-contacto');
    }

    public function actionRedesSociales()
    {
        $this->view->H1         = Yii::t('app', 'Mi cuenta - redes sociales');
        $this->view->iconClass  = 'user';
        $this->model            = RedesSociales::find()->where('id=:id', [':id' =>  Yii::$app->user->identity->id ])->one();

        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha actualizado sus redes sociales</h5>') );

        return $this->renderAjax('redes-sociales');
    }

    public function actionCambiarPassword()
    {
        $this->model = Password::find()->where('id=:id', [':id' =>  Yii::$app->user->identity->id ])->one();

        if($this->model->requiere_cambio_pass)
            $this->view->H1 = Yii::t('app', 'Cambiar contraseña');
        else
            $this->view->H1 = Yii::t('app', 'Mi cuenta - Cambiar contraseña');

        $this->view->iconClass = 'lock';

        if($this->model->requiere_cambio_pass == 0 && !Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        if(Yii::$app->request->isPost)
            return $this->processForm( Yii::t('app', '<h5 class="margin-v-15">Ha actualizado su contraseña de acceso</h5>') );

        if($this->model->requiere_cambio_pass)
        {
            $this->layout = '@layouts/blank';
            $view         = 'cambiar-require-password';
        }
        else
            $view = 'cambiar-password';

        return (Yii::$app->request->isAjax) ? $this->renderAjax($view) : $this->render($view);
    }
}
