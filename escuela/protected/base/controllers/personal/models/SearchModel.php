<?php
namespace controllers\personal\models;
use Yii;
use yii\data\ActiveDataProvider;

class SearchModel extends Personal
{
	public function rules()
	{
		return [
			[['nombres', 'apellidos', 'email', 'nro_documento'], 'safe'],
		];
	}

	public function addCommonFilters(&$query)
	{

        $query->andFilterWhere(['like', 'nro_documento', $this->nro_documento])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos]);
	}

	public function searchByProfile($idProfile, $params)
	{
		$idProfile = (int) $idProfile;
		$activos   = ($this->activo === true || $this->activo === false) ? $this->activo : true;

		$query = static::find();
		$this->load($params);
		$this->addCommonFilters($query);

		$query->andWhere('id_perfil = :idPerfil' , [ ':idPerfil' => $idProfile]);
		$query->andWhere('activo = :activo' , [':activo' => $activos]);

		return  new ActiveDataProvider([
			'query' => $query,
			'pagination' 	=> [
				'pageSize' => 20
			],
			'sort' => [
				'defaultOrder'=>[
					'id' => SORT_DESC,
				]
			]
		]);
	}

	public function searchSinSucursal($idProfile, $params)
	{
		$query = static::find();
		$this->load($params);
		$this->addCommonFilters($query);

		$query->andWhere('id_perfil = :idPerfil' , [ ':idPerfil' => $idProfile]);
		$query->andWhere('id not in (select id_usuario from usuario_sucursal)');

		return  new ActiveDataProvider([
			'query' => $query,
			'pagination' 	=> [
				'pageSize' => 20
			],
			'sort' => [
				'defaultOrder'=>[
					'id' => SORT_DESC,
				]
			]
		]);
	}

	public function searchBySucursal($idProfile, $idSucursal, $actives, $params)
	{

	}
}
