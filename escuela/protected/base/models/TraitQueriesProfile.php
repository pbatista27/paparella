<?php
namespace base\models;

use Yii;
use yii\data\ActiveDataProvider;


use app\models\Sucursal;
use app\models\UsuarioSucursal;
use app\models\CursoSucursal;
use app\models\CursadaAsistencia;

/*
	Toda este Trait retornar un activeActiveDataProvider o un activeQuery
*/
Trait TraitQueriesProfile
{
	public function querySucursales()
	{
		$query = Sucursal::find();

        if($this->isAdmin())
			return $query;

		$query->join('INNER JOIN', 'usuario_sucursal as us', 'us.id_sucursal = sucursal.id');
		$query->join('INNER JOIN', 'usuario as u', 'us.id_usuario = u.id');
		$query->andWhere('u.id = :id and u.id_perfil in (2,3)', [
		    ':id' => $this->id
		]);

		return $query;
	}
}
