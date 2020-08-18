<?php
namespace controllers\ajax;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;

use app\models\Localidad;
use app\models\Sucursal;
use app\models\Usuario;
use app\models\Curso;

class Controller extends \base\Controller
{
    public function beforeAction($action)
    {
        if(parent::beforeAction($action) == false)
            return false;

        if(!Yii::$app->request->isAjax)
            throw new HttpException(400, Yii::t('app', 'Petición invalida'));

        return true;
    }

	public function actionLocalidad($q = null)
	{
		$query = Localidad::find();
		$query->select('id, keyword AS text')
			->from(Localidad::tableName())
			->orderBy('keyword asc');

		foreach(Yii::$app->tools->arrayKeywords($q) as $key => $value)
			$query->andFilterWhere(['LIKE', 'keyword', $value ]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => -1,
			]
		]);

		$response['results']	= [];
		if($dataProvider->count > 0)
			$response['results'] = $dataProvider->query->asArray()->all();

		//@todo add paginacion + resultados
		return $this->asJson($response);
	}

	public function actionSucursal($q = null)
	{
		$query = Sucursal::find();
		$query->select('id, nombre AS text')
			->from(Sucursal::tableName())
			->orderBy('nombre asc');

		foreach(Yii::$app->tools->arrayKeywords($q) as $key => $value)
			$query->andFilterWhere(['LIKE', 'nombre', $value ]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => -1,
			]
		]);

		$response['results']	= [];
		if($dataProvider->count > 0)
			$response['results'] = $dataProvider->query->asArray()->all();

		//@todo add paginacion + resultados
		return $this->asJson($response);
	}
}
