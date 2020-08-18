<?php
namespace base\helpers;

use Yii;
use yii\data\DataProvider;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

use yii\data\Pagination;
use yii\data\Sort;

use yii\db\Query;
use yii\db\ActiveQuery;
use yii\di\Instance;

class Queries extends \yii\base\BaseObject
{
	public $db;

	public function init()
	{
		parent::init();
		if(is_null($this->db))
			$this->db = Instance::ensure('db', 'yii\db\Connection');
	}

	public function now()
	{
		$sql = 'select now()';
		return $this->db->createCommand($sql)->queryScalar();
	}

	public function getEstadisticasPersonal()
	{
		$sql = '
		select
			(select count(u.id) from usuario as u where id_perfil = 2 and activo = 1) as nro_admin_activos,
			(select count(u.id) from usuario as u where id_perfil = 2 and activo = 0) as nro_admin_inactivos,
			(select count(u.id) from usuario as u where id_perfil = 2 and u.id not in (select id_usuario from usuario_sucursal))  as nro_admin_sinsucursal,

			(select count(u.id) from usuario as u where id_perfil = 3 and activo = 1) as nro_docentes_activos,
			(select count(u.id) from usuario as u where id_perfil = 3 and activo = 0) as nro_docentes_inactivos,
			(select count(u.id) from usuario as u where id_perfil = 3 and u.id not in (select id_usuario from usuario_sucursal))  as nro_docentes_sinsucursal
		';

		return $this->db
			->createCommand($sql)
			->queryOne(\PDO::FETCH_OBJ);
	}

	public static function instance($config = [])
	{
		$config['class'] = static::className();
		return Yii::createObject($config);
	}
}
