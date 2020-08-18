<?php
namespace controllers\personal\actions;

use Yii;
use yii\web\HttpException;
use controllers\personal\models\SearchModel;

class ToggleStatusAction extends \yii\base\Action
{
	public $key = 'id';
	public $model;
	public $columnStatus = 'activo';

	public function run()
	{
		$id    = (int) Yii::$app->request->getQueryParam($this->key, 0);
		$model = SearchModel::findOne($id);

		if(!$model)
			throw new HttpException( 404, Yii::t('app', 'Contenido no existe ó ha sido elimindo'));

		$user  = Yii::$app->user->identity;

		if(!in_array($model->id_perfil, [ $model::PROFILE_ADMIN_SUCURSAL, $model::PROFILE_DOCENTE]))
			throw new HttpException(412, Yii::t('app', 'Tipo de usuario invalido') );

		if($user->isAdmin() || $user->isAdminSucursal() )
		{
			if( $user->isAdminSucursal() &&  $model->id_perfil == $model::PROFILE_ADMIN_SUCURSAL )
				throw new HttpException(403, Yii::t('app', 'Sin permisos para visualizar este contenido'));

			$model->{$this->columnStatus} = !$model->{$this->columnStatus};

			try{
				$model->update(false, [$this->columnStatus]);
			}
			catch(\Exception $e){
			}
		}
		else
			throw new HttpException(403, Yii::t('app', 'Sin permisos para visualizar este contenido'));
	}
}
