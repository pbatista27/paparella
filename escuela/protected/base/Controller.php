<?php
namespace base;
use Yii;
use yii\helpers\Url;
use yii\helpers\Json;

abstract class Controller extends \yii\web\Controller
{
	private $app;
	public $pjaxId;
	public $defaultRoute;
	public $currentRoute;
	public $currentModule;
	public $currentController;
	public $currentAction;
	public $currentUrl;
	public $defaultRouteUrl;
	public $model;

	public $layout = '@layouts/dashboard';

	public function __construct($id, $module, $config = [])
	{
        parent::__construct($id, $module, $config = []);
        $this->app = ($module->module)?: Yii::$app;

        $moduleId         = ($this->module->id != $this->app->id)? $this->module->id  : null;
        $isSiteController = is_null($moduleId) ? true : false;

		if($isSiteController)
			$this->defaultRoute = '/' . $this->app->defaultRoute;
		else
			$this->defaultRoute = sprintf('/%s/%s/%s',  $this->module->id, $this->module->defaultRoute , $this->defaultAction);

		$this->currentModule     = '/' . (($isSiteController) ? null : $this->module->id);
		$this->currentController = '/' . (($isSiteController) ?  $this->id : $moduleId . '/' . $this->id);

		// buscar actionId:
		$routePart = explode('/', $this->app->requestedRoute);
		if($this->app->hasModule( $moduleId ))
			$this->currentAction  = (count($routePart) >= 3) ? end($routePart) : $this->defaultAction;

		else{
			$this->currentAction = (count($routePart) > 2) ? null : @$routePart[1];
			$this->currentAction = is_null($this->currentAction) ? 'error' : $this->currentAction;
		}

		$this->defaultRouteUrl = Url::toRoute(['/'. $this->defaultRoute ]);
		$this->currentRoute    = ($isSiteController) ? sprintf('/%s/%s', $this->id, $this->currentAction ) : sprintf('/%s/%s/%s', $this->module->id, $this->id, $this->currentAction );
		$this->currentUrl 	   = Url::toRoute([ $this->currentRoute , (Yii::$app->request->get() ?: []) ]);

		if(empty($this->pjaxId))
		{
			if($isSiteController)
				$this->pjaxId = strtolower($this->id . '-' . $this->currentAction);
			else
				$this->pjaxId = strtolower($moduleId . '-' . $this->id . '-' . $this->currentAction);
		}

		$this->on(static::EVENT_BEFORE_ACTION, function(){

			$user = $this->app->user;

			if(!$user->isGuest)
			{
				if($user->identity->requiere_cambio_pass == 1)
				{
					$this->layout = '@layouts/blank';

					$routes = [
						'/account/cambiar-password',
						'/site/logout',
					];

					if(!in_array($this->currentRoute, $routes))
					{
						$url = Url::toRoute(['/account/cambiar-password']);
						return $this->app->response->redirect($url);
					}
				}

				return;
			}

			$this->layout = '@layouts/main';

			$isModalOpen = $this->app->request->getQueryParam('modal-load', 0);
			$isModalOpen = $isModalOpen === 0 ? false : true;
			$isAjax      = $this->app->request->isAjax;

			if($isAjax && $isModalOpen && $this->currentRoute !='/site/login')
			{
				$response = $this->app->response;
				$response->setStatusCode(401);
				$response->content = Yii::t('app', 'Es requerido inicio de sesión ');
				$this->app->end();
			}
		});

		// setup default Pjax
		// @todo add yii\widgets\Pjax::EVENT_INIT  "timeout":3680 * 1000 (una hora)
	}

    public function goHome()
    {
        if(Yii::$app->user->isGuest)
            return parent::goHome();

        $dashboardHome = Yii::$app->user->identity->dashboardHome();

        if($dashboardHome == false)
        	return parent::goHome();
        else
        	return $this->redirect($dashboardHome);
    }
}
